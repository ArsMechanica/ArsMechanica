<?php
if( isset( $_POST['user_check_promocode'] ) ) {

$userCode = $_POST["promocode"];
$userDate = date("Y-m-d");

$doc = new DOMDocument;
$doc->load('./plugins/promo-codes/base/promo-codes.xml');
$xpath = new DOMXPath($doc);

$codes = $xpath->query('/codes/code[@id="'.$userCode.'"]');
$userCodeDateEnd = $codes->item(0)->getElementsByTagName('dateend')->item(0)->nodeValue; // Определение дату действия кода

print_r ($codes); // Проверка
if(!$codes->length < 1) {
echo 'Код есть';
} else {
echo 'Кода нет';
}

} else {
echo '
<form method="POST" enctype="multipart/form-data">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
        <input id="promo-form" class="form-control" type="text" name="promocode" size="20" placeholder="введите Промо-код" value="" required/>
        <span class="input-group-btn">
<button class="btn btn-info" type="submit" name="user_check_promocode">Проверить<span class="hidden-sm hidden-xs"> код</span></button>
</span>
    </div>
</form>
';
}
?>