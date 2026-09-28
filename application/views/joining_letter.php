<br>
<br>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Your New Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        p{
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<!-- < ?php dd($values)?> -->
<body>
    <div class="container break_page" style=" font-family: sutonnymj;width:50%">
        <div class="d-flex text-center" >
            <div class="col-md-2">
                <img src="path/to/your/logo.png" alt="Logo" style="max-width: 100%;">
            </div>
            <div class="col-md-6">
                <h3 class="text-center">nvwbI‡qj Mv‡g©›Um wjwg‡UW</h3>
            </div>
            <div class="col-md-4">
                <p style="font-family: Arial, Helvetica, sans-serif;">HGL/HRD(HR)/03/008</p>
            </div>
        </div>
    <div>
    <div class="col-md-12" style="border-bottom: 1px solid black!important;">
        <p class="text-center h6">799, (cyivZb cøU bs- 1010/1011), AvgevM, ‡gŠRv evwNqv, ‡Kvbvevox, MvRxcyi-1700|</p>
    </div>
                <!-- <div class="row"> -->
    <h3 class="text-center mt-2"><b style="border: 2px solid black;">Kv‡R †hvM`vb cÎ</b></h3>
                <!-- </div> -->
    <?php foreach($values as $value){?>            
        <div class="row">
            <div class="col-md-6 mt-4">
                <table>
                    <tr>
                        <th>AvBwW bs </th>
                        <td> t </td>
                        <td><?php echo $value->emp_id?></td>
                    </tr>
                    <tr>
                        <th>ZvwiL </th>
                        <td> t </td>
                        <td><?php echo $value->emp_join_date?> Bs</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-12">
                <p>eivei,</p>
                <p>cwiPvjK/wbev©nx cwiPvjK/gnve¨e¯’vcK/KviLvbv e¨e¯’vcK</p>
                <p>KviLvbvi bvg t nvwbI‡qj Mv‡g©›Um wjwg‡UW</p>
                <p>wVKvbv t 799 (cyivZb cøU bs-1010/1011) AvgevM, †gŠRv evwNqv, ‡Kvbvevox, MvRxcyi|</p>
                
                
                
                <p>welq t Kv‡R †hvM`vb cÎ</p>
                
                <p>Rbve/Rbvev,</p>
                <p> Avcbvi wbKU †_‡K cªvß wb‡qvM cÎ AvBwW bst <?php echo $value->emp_id?> ,ZvwiLt <?php echo $value->emp_join_date?> Bs Gi ‡cªwÿ‡Z Rvbv‡bv
                hv‡”Q †h Avwg A`¨ <?php echo $value->emp_join_date?> Bs ZvwiL n‡Z Avcbvi wkícÖwZôv‡b Dc‡i D‡jwLZwb‡qvM c‡Îi kZ©
                †gvZv‡eK <?php echo"<span style='font-size:12px'>". $value->desig_bangla."</span>"?> c‡` †hvM`vb Kijvg|</p>
                <p> AZGe Avcbvi wbKU Av‡e`b GB †h, Avgvi `vwLjK„Z Kv‡R †hvM`vb cÎwU MÖnY K‡i evwaZ Ki‡eb|</p>
                
                
                <p>ab¨ev`v‡šÍ</p>
                
                Avcbvi wek¦¯Í
                
            </div>
            
            <div class="col-md-6">
                <p>¯^vÿi t ................ √.......................</p>
                <p>bvg t <?php echo "<span style='font-size:12px'>".$value->name_bn."</span>"?></p>
                <p>c`ex t <?php echo "<span style='font-size:12px'>".$value->desig_bangla."</span>"?></p>
            </div>
        </div>
    <?php }?>
    <br>
<br>

</body>

</html>