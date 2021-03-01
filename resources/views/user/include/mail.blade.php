<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .main-logo {
            width: auto;
            height: auto;
            max-width: 150px;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
            height: 100vh;
        }

        .main__container {

        }

        .mail {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100vw;
        }

        .mail__container {
            font-size: 14px;
            color: #585858;
            text-align: center;
            background: #fff;
            border: 1px solid #eaeaea;
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            padding: 30px 50px;
        }

        .mail__header {
        }

        .mail__title {
            font-size: 1.125rem;
            font-weight: 700;
            line-height: 1.5rem;
            padding: 15px 0;
            text-align: center;
        }

        .mail__body {
            margin: 15px 0;
        }

        .mail__desc {
            text-align: center;
        }

        .mail__footer {
        }

        .btn-agree {
            border: 0;
            padding: 0;
            margin: 0;
            outline: none;
            text-align: center;
            font-size: 0.875rem;
            border-radius: 3px;
            display: inline-block;
            cursor: pointer;

            background: #EE4040;
            color: #fff !important;
            width: 100%;
            height: 3rem;
            line-height: 3rem;
        }

    </style>
</head>
<body>
<div id="wrap">

    @yield('main')

</div>
</body>
</html>