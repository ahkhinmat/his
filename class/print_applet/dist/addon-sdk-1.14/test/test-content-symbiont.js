/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. */

"use strict";

const { Cc, Ci } = require('chrome');
const { Symbiont } = require('sdk/content/symbiont');
const self = require("sdk/self");

function makeWindow() {
  let content =
    '<?xml version="1.0"?>' +
    '<window ' +
    'xmlns="http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul">' +
    '<iframe id="content" type="content"/>' +
    '</window>';
  var url = "data:application/vnd.mozilla.xul+xml;charset=utf-8," +
            encodeURIComponent(content);
  var features = ["chrome", "width=10", "height=10"];

  return Cc["@mozilla.org/embedcomp/window-watcher;1"].
         getService(Ci.nsIWindowWatcher).
         openWindow(null, url, null, features.join(","), null);
}

exports['test:constructing symbiont && validating API'] = function(assert) {
  let contentScript = ["1;", "2;"];
  let contentScriptFile = self.data.url("test-content-symbiont.js");

  // We can avoid passing a `frame` argument. Symbiont will create one
  // by using HiddenFrame module
  let contentSymbiont = Symbiont({
    contentScriptFile: contentScriptFile,
    contentScript: contentScript,
    contentScriptWhen: "start"
  });

  assert.equal(
    contentScriptFile,
    contentSymbiont.contentScriptFile,
    "There is one contentScriptFile, as specified in options."
  );
  assert.equal(
    contentScript.length,
    contentSymbiont.contentScript.length,
    "There are two contentScripts, as specified in options."
  );
  assert.equal(
    contentScript[0],
    contentSymbiont.contentScript[0],
    "There are two contentScripts, as specified in options."
  );
  assert.equal(
    contentScript[1],
    contentSymbiont.contentScript[1],
    "There are two contentScripts, as specified in options."
  )
  assert.equal(
    contentSymbiont.contentScriptWhen,
    "start",
    "contentScriptWhen is as specified in options."
  );

  contentSymbiont.destroy();
};

exports["test:communication with worker global scope"] = function(assert, done) {
  let window = makeWindow();
  let contentSymbiont;

  function onMessage1(message) {
    assert.equal(message, 1, "Program gets message via onMessage.");
    contentSymbiont.removeListener('message', onMessage1);
    contentSymbiont.on('message', onMessage2);
    contentSymbiont.postMessage(2);
  };

  function onMessage2(message) {
    if (5 == message) {
      window.close();
      done();
    } else {
      assert.equal(message, 3, "Program gets message via onMessage2.");
      contentSymbiont.postMessage(4)
    }
  }

  window.addEventListener("load", function onLoad() {
    window.removeEventListener("load", onLoad, false);
    let frame = window.document.getElementById("content");
    contentSymbiont = Symbiont({
      frame: frame,
      contentScript: 'new ' + function() {
        self.postMessage(1);
        self.on("message", function onMessage(message) {
          if (message === 2)
            self.postMessage(3);
          if (message === 4)
            self.postMessage(5);
        });
      } + '()',
      contentScriptWhen: 'ready',
      onMessage: onMessage1
    });

    frame.setAttribute("src", "data:text/html;charset=utf-8,<html><body></body></html>");
  }, false);
};

exports['test:pageWorker'] = function(assert, done) {
  let worker =  Symbiont({
    contentURL: 'about:buildconfig',
    contentScript: 'new ' + function WorkerScope() {
      self.on('message', function(data) {
        if (data.valid)
          self.postMessage('bye!');
      })
      self.postMessage(window.location.toString());
    },
    onMessage: function(msg) {
      if (msg == 'bye!') {
        done()
      } else {
        assert.equal(
          worker.contentURL + '',
          msg
        );
        worker.postMessage({ valid: true });
      }
    }
  });
};

exports["test:document element present on 'start'"] = function(assert, done) {
  let xulApp = require("sdk/system/xul-app");
  let worker = Symbiont({
    contentURL: "about:buildconfig",
    contentScript: "self.postMessage(!!document.documentElement)",
    contentScriptWhen: "start",
    onMessage: function(message) {
      if (xulApp.versionInRange(xulApp.platformVersion, "2.0b6", "*"))
        assert.ok(message, "document element present on 'start'");
      else
        assert.pass("document element not necessarily present on 'start'");
      done();
    }
  });
};

exports["test:direct communication with trusted document"] = function(assert, done) {
  let worker = Symbiont({
    contentURL: require("sdk/self").data.url("test-trusted-document.html")
  });

  worker.port.on('document-to-addon', function (arg) {
    assert.equal(arg, "ok", "Received an event from the document");
    worker.destroy();
    done();
  });
  worker.port.emit('addon-to-document', 'ok');
};

exports["test:`addon` is not available when a content script is set"] = function(assert, done) {
  let worker = Symbiont({
    contentURL: require("sdk/self").data.url("test-trusted-document.html"),
    contentScript: "new " + function ContentScriptScope() {
      self.port.emit("cs-to-addon", "addon" in unsafeWindow);
    }
  });

  worker.port.on('cs-to-addon', function (hasAddon) {
    assert.equal(hasAddon, false,
      "`addon` is not available");
    worker.destroy();
    done();
  });
};

if (require("sdk/system/xul-app").is("Fennec")) {
  module.exports = {
    "test Unsupported Test": function UnsupportedTest (assert) {
        assert.pass(
          "Skipping this test until Fennec support is implemented." +
          "See bug 806815");
    }
  }
}

require("test").run(exports);
