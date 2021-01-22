<?php	 
require_once('mpdf.php');

$mpdf=new mPDF('');
$mpdf->percentSubset = 0;
$mpdf->SetImportUse(); 

// forces no subsetting - otherwise the inserted characters may not be contained in a subset font
 

$search = array(
        'years', 
        'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXZZZZZZZZ'
);


$replacement = array(
        "c",
        "COPYRIGHT: Licensed to Jos\xc3\xa9 Bloggs"
);

$mpdf->OverWrite('dien tim di dong.pdf', $search, $replacement, 'I', 'mpdf.pdf' ) ;




/*$mpdf=new mPDF('','','','',15,15,57,16,9,9); 
$mpdf->SetImportUse();	
$mpdf->SetDisplayMode('fullpage');

$mpdf->SetCompression(false);

// Add First page


$mpdf->SetSourceFile('dien tim di dong.pdf');
$tplIdx = $mpdf->importPage(1);
$mpdf->useTemplate($tplIdx, 10, 10, 200);

$mpdf->SetFont('helvetica', '', 9);
	 
	$mpdf->SetTextColor(0, 0, 0);
	$mpdf->SetXY(30, 110);
	$str='ộ';
	//$str = iconv('utf-8', 'ISO-8859-1//TRANSLIT', $str);
	//$str = iconv('UTF-8', 'ISO-8859-1//TRANSLIT', utf8_encode($str));
	//$str =iconv($matches[1], 'utf-8//TRANSLIT', $str);
$mpdf->MultiCell(0,5," Số thai: một thai. Cử động thai: ( + ). Ngôi thai: XXX.
- Đo đạc  (+/- XXX gram)
- Khảo  sát hình thái:  
   + Đầu,  cổ: Vòm  sọ liên tục, hình dạng bình thường, đường giữa không lệch, hai bán  cầu đại não cân  đối, vách trong  suốt thấy, hệ thống não thất (ngã ba não thất: xxx mm), đồi thị, tiểu não ( xxx mm), thuỳ nhộng, hố lớn ( XXX mm) bình thường.
   + Mặt: Khoảng cách giữa hai hốc mắt bình thường, thuỷ tinh thể bình thường, chiều dài xương mũi: XXX mm, môi cằm bình thường.
   + Ngực: Lồng ngực bình thường.
   + Tim: Vị trí, trục, kích thước tim bình thường, nhịp đều, tần số: xxx lần/phút,  4 buồng tim, đ/m Chủ và đ/m Phổi  bắt chéo bình thường. Hình ảnh ba mạch máu bình thường, không tràn dịch màng tim.
   + Phổi: Nhu mô phổi  đồng nhất, không thoát vị hoành, không tràn dịch màng phổi.");

 



$mpdf->Output('newpdf.pdf', 'I');
$mpdf->Output('newpdf.pdf', 'f');*/

exit;
?>
 
 