<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<style>
    body {
        background-color: #f15b5b !important;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    
    .content-wrapper {
        background-color: white;
        margin-top: 30px;
        border-radius: 6px;
    }
    /*-----------------------------------------------------------------------------------*/
    
    .nav-item {
        background-color: #e64343;
        border-radius: 8px;
    }
    
    .nav-item:hover {
        background-color: #b62b2b;
    }
    
    .nav-item-active {
        background-color: #b62b2b;
    }
</style>

<body>
    <nav class="navbar navbar-light" style="background-color: #047cc2;">
        <div class="container">
            <a>
                <div>
                    <img src="../img/love.svg" width=40 height=40>
                    <div style="color:white; font-size:22px; position:absolute; top:13px; margin-left:8px; display:inline-block;">帛宗長照</div>

                </div>
            </a>
            <div style="width:200px">
                <div class="dropdown" style="float:right;">
                
                    <a class="btn dropdown-toggle text-light" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size:20px; padding-top:0px; padding-bottom:0px;"></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="margin-top:12px;">
                        <a class="dropdown-item" href="{{ url('/logout') }}">登出</a>
                    </div>
                </div>
                <span class="text-light" style="float:right; margin-top:3px;">用戶 : {{ $user[0]['username'] }}</span>
            </div>
        </div>
    </nav>
    <div class="row">
        <div class="col-2 ml-3 mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showexecutive') }}">行政人員表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcaredfamily') }}">家庭代碼表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcarers') }}">照護人員表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ url('/showcarestation') }}">派駐資料表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-item-active text-light" href="{{ url('/crossdatasearch') }}">跨資料整合</a>
                </li>
                @if($Authority == 'super user')
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ url('/usersetting') }}">使用者設定</a>
                    </li>
                @endif
            </ul>
        </div>
        <div class="col-8">
            <div class="container text-light">
                <center class="pt-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <h3 class="text-left">薪資在25000元以上之照護人員人數:</h3>
                                <div class="text-left">北區: {{ $north_salary_bigger_25000 }} 人</div>
                                <div class="text-left">中區: {{ $west_salary_bigger_25000}} 人</div>
                                <div class="text-left">南區: {{ $south_salary_bigger_25000}} 人</div>
                                <div class="text-left">東區: {{ $east_salary_bigger_25000}} 人</div>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-left">區域之照護人員人數:</h3>
                                <div class="text-left">北區: {{ $north_carers }} 人</div>
                                <div class="text-left">中區: {{ $west_carers }} 人</div>
                                <div class="text-left">南區: {{ $south_carers }} 人</div>
                                <div class="text-left">東區: {{ $east_carers }} 人</div>
                            </div>
                            <div class="col-md-4">
                                <h3 class="text-left">區域之大於30歲照護人員所照護之受照護人平均年齡:</h3>
                                <div class="text-left">北區: {{ $average_north }} 歲</div>
                                <div class="text-left">中區: {{ $average_west }} 歲</div>
                                <div class="text-left">南區: {{ $average_south }} 歲</div>
                                <div class="text-left">東區: {{ $average_east }} 歲</div>
                            </div>
                        </div>


                    </div>
                </center>
                <div class="col-2"></div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>