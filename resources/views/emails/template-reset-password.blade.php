<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    * {
        box-sizing: border-box;
    }

    .row{
        background-color: #ffffff;
        width: 500px;
        margin: auto;
        padding: 30px;
        text-align: justify;

    }

    body {
        margin:25px;
        background-color: #ececec;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

</style>
</head>
<body>
    <div class="row">
        <p>Hai {{ $details['name'] }},</p>
        <p>{{ $details['message'] }}</p>
        <p>{{ $details['sub_message'] }}</p>
        <hr>
        <table style="border:1px solid #cecece; padding:5px; width:100%;">
            @if($details['type'])
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><b>{{ $details['username'] }}</b></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td><b>{{ $details['password'] }}</b></td>
                </tr>
            @else
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><b>{{ $details['username'] }}</b></td>
                </tr>
                <tr>
                    <td>Full Name</td>
                    <td>:</td>
                    <td><b>{{ $details['full_name'] }}</b></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td>:</td>
                    <td><b>{{ $details['email'] }}</b></td>
                </tr>
            @endif
        </table>
        <br>
        <a href="{{ $details['url'] }}" style="color: #3579f6;" target="_blank" rel="noopener noreferrer">
            {{ $details['label_url'] }}
        </a>
        <br>
    </div>
</body>
</html>
