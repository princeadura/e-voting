<link rel="stylesheet" href="http://localhost:100/bootstrap.min.css">
<link rel="stylesheet" href="http://localhost:100/fontawesome6/css/all.min.css">
<link rel="stylesheet" href="http://localhost:100/dataTables/dataTables.min.css">
<?php
if ($group == "landing") {
    echo '<link rel="stylesheet" href="./../assets/styles/css/landing.css">';
} else if ($group == "admin") {
    echo '<link rel="stylesheet" href="./../assets/styles/css/admin.css">';
}
?>