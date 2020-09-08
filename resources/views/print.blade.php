<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
@foreach ($daily->product as $product)
  <table style="height: 40px; width: 100%; border-collapse: collapse; border-style: hidden; margin-left: 50px">
    <tbody>
      <tr style="height: 10px;">
        <td style="width: 55.414%; height: 15px;" colspan="2">{{$product->product}}</td>
      </tr>
      <tr style="height: 10px;">
        <td style="width: 1%; height: 15px;">x</td>
        <td style="width: 48.9889%; height: 15px;">{{$product->quantity}}</td>
        <td style="width: 30.441%; height: 15px;">Rp{{$product->sub_total}}</td>
      </tr>
    </tbody>
  </table>
  <p></p>
  <hr class="solid">
  @endforeach
</body>
</html>