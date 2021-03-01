<html>
<head>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <title>KSPay {{ $rcid }}</title>
    <script language="JavaScript">
        function init() {
            if (top.opener == null || typeof(top.opener) == "undefined" || typeof(top.opener.goResult) == "undefined") {
                alert("ERROR: 주문페이지를 확인할 수 없어 결제를 중단합니다!!");
                modalClose();
                return;
            }

            @if (empty($rcid) && 10 > strlen($rcid))
                alert("ERROR: 결제요청정보({{ $rcid }})를 확인할 수 없어 결제를 중단합니다!!");
                modalClose();
                return;
            @else
                top.opener.goResult("{{ $rcid }}","{{ $rctype }}","{{ $rhash }}");
            @endif

            setTimeout(modalClose(), '1000');
        }

        function modalClose() {
            window.close();
        }

        init();
    </script>
</head>
<body>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="middle" align="center"><table width="450" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td><img src="//kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/processing.gif" width="450" height="141"></td>
                </tr>
                <tr>
                    <td><img src="//kspay.ksnet.to/store/KSPayFlashV1.3/mall/imgs/process_step.gif" width="456" height="20"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>