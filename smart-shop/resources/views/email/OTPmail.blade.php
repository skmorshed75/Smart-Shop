<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        $font-title: 'Open Sans';
    
        @import url('https://fonts.googleapis.com/css?family=Open+Sans');
    
        * { box-sizing: border-box; }
        body {
            background-color: #fafafa;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .c-email {
            width: 40vw;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0px 7px 22px 0px rgba(0, 0, 0, .1);
            &__header {
                background-color: #0fd59f;
                width: 100%;
                height: 60px;
                &__title {
                font-size: 23px;
                font-family: $font-title;
                height: 60px;
                line-height: 60px;
                margin: 0;
                text-align: center;
                color: white;
                }
            }
            &__content {
                width: 100%;
                height: 300px;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                align-items: center;
                flex-wrap: wrap;
                background-color: #fff;
                padding: 15px;
                &__text {
                font-size: 20px;
                text-align: center;
                color: #343434;
                margin-top: 0;
                }
            }
            &__code {
                display: block;
                width: 60%;
                margin: 30px auto;
                background-color: #ddd;
                border-radius: 40px;
                padding: 20px;
                text-align: center;
                font-size: 36px;
                font-family: $font-title;
                letter-spacing: 10px;
                box-shadow: 0px 7px 22px 0px rgba(0, 0, 0, .1);
            }
            &__footer {
                width: 100%;
                height: 60px;
                background-color: #fff;
            }
        }
    
        .text-title {
            font-family: $font-title;
        }
        .text-center {
            text-align: center;
        }
        .text-italic {
            font-style: italic;
        }
        .opacity-30 {
            opacity: 0.3;
        }
        .mb-0 {
            margin-bottom: 0;
        }    
    </style>    
</head>
<body>
    <div class="c-email">  
        <div class="c-email__header">
          <h1 class="c-email__header__title">Your Verification Code</h1>
        </div>
        <div class="c-email__content">
          <p class="c-email__content__text text-title">
            Enter this verification code in field:
          </p>
          <div class="c-email__code">
            <span class="c-email__code__text">{{$otp}}</span>
          </div>
          <p class="c-email__content__text text-italic opacity-30 text-title mb-0">Verification code is valid only for 60 minutes</p>
        </div>
        <div class="c-email__footer"></div>
    </div>    
</body>
</html>



  
