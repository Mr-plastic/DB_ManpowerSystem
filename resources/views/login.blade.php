<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" rel="stylesheet"></link>

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
    /*--------------------------------------------------------------------------------------*/
    
    .email-wrapper {
        width: 100%;
        /* 讓register-wrapper遠離topbar */
        z-index: 0;
        display: inline-block;
    }
    
    .email-content-container {
        min-width: 1260px;
    }
    
    .email-content {
        background-color: white;
        width: 500px;
        height: 400px;
        padding: 34px 20px 10px 20px;
        margin: 0 auto;
        margin-top: 110px;
        border-radius: 12px;
    }
    
    .email-content img {
        width: 250px;
        height: 160px;
        margin-left: 100px;
    }
    
    .email-content p {
        font-family: Microsoft JhengHei;
        text-align: center;
    }
    
    .example {
        color: #3397CF;
        text-align: center;
        font-size: 18px;
    }
    
    .notget {
        margin-top: 40px;
        text-align: center;
    }
    
    .notget a {
        color: #3397CF;
        text-decoration: none;
        font-family: Microsoft JhengHei;
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
            
            <span class="text-light" style="margin-right:20px;">網站造訪人數 : {{ $count }}</span>
        </div>
    </nav>
    <div class="email-wrapper">
        <div class="email-content-container">
            <div class="email-content">
                <form class="container" action="post-login" method="post">
                    @csrf
                    <h3 class="text-center">後台登入系統</h3>
                    <div class="form-group">
                        <label for="exampleInputEmail1">帳號:</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Enter username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">密碼:</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    @if(session('message'))
                        <small id="emailHelp" class="form-text text-muted">{{ session('message')}}</small>
                    @endif
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 50px;">Login</button>
                </form>
            </div>
            </form>
        </div>


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js " integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js " integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k " crossorigin="anonymous "></script>
</body>

</html>