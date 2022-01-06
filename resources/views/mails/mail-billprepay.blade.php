<!DOCTYPE html>
<html>
<head>
    <title>AlphaCep Suite</title>
</head>
<body>
    {{ $employee_name }}様
    <br><br>

    以下の金額を所定の銀行口座へお振込いたしました。また返信は不要です。ただし口座名義を変更した方は必ず連絡ください。
    <br><br>

    振込日付： {{ $pay_day }}
    <br>
    合計： {{ $money }}

    <br>
    備考： {{ $note }}


    <br><br>
    -----------------------<br>
    {{ $url }}

</body>
</html>
  