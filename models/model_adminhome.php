<?php 
	ob_start();
?>
<div class="col-lg-1" id="menu-menu" style="min-width: 150px;">
    <ul class="list-group">
        <li class="list-group-item active"><a href="?page=adminhome" style="color: #fff;"><i class="glyphicon glyphicon-home"></i>   home</a></li>
        <li class="list-group-item"><a href="?page=qcmqcm">Créer QCM</a></li>
        <li class="list-group-item"><a href="?page=gestion_theme">Thèmes</a></li>
        <li class="list-group-item"><a href="?page=gestion_qcm">Gérer QCM</a></li>
        <li class="list-group-item"><a href="?page=note_enseignant">Notes</a></li>
    </ul>
</div>
<?php
	$menu = ob_get_clean();
?>