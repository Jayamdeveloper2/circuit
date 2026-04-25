<?php
include APPPATH . "/Views/admin/common/header.php";
?>
<body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof ClassicEditor !== 'undefined') {
                document.body.innerHTML += "<h1>ClassicEditor is DEFEINED</h1>";
            } else {
                document.body.innerHTML += "<h1>ClassicEditor is NOT DEFINED</h1>";
            }
        });
    </script>
</body>
</html>
