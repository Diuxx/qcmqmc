
<div id="corp-page" class="container-fluid" style="padding-top: 10px;">
	<div class="row">
		<?= $menu ?>

	    <!-- message authentification -->
	    <div class="col-md-6 col-md-offset-2" id="messagemessage">
	        <!-- code code code -->
	    </div>

		<div class="col-lg-8 col-lg-offset-1">
		    <div class="container-fluid">
		        <div class="row">
		            <div class="col-sm-6 col-lg-offset-0" id="qcm-question" style="max-height: ">
		                <!-- recherche par themes -->
		                <div class="row">
		                    <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;">
		                        <div class="form-group">
		                            <div class="col-sm-5 col-sm-offset-4">
		                                <div class="input-group">
		                                    <select class="form-control select-theme2" onchange="aj_afficherQuestion(this.value)" id="select-theme2">
		                                        <option value="-1">Tous les themes</option>
		                                        <!-- ajout des themes js -->
		                                    </select>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div> 
		                <table class="table">
		                    <tbody id="list-question">
		                        <!-- liste des question (chargement) -->
		                        <tr>
		                            <td>Informatique général</td>
		                            <td><button type="submit" class="btn btn-primary btn-xs">ajouter >></button></td>
		                        </tr>
		                    </tbody>
		                </table>            
		            </div>

		            <div class="col-sm-6 col-lg-offset-0" id="qcm-nouveau-qcm" style="border: 1px solid #e0e0e0;">

		                <div class="container-fluid">
		                    <div class="row">
		                        <form method="post" action="?page=qcmqcm">
		                            <button type="submit" class="btn btn-primary btn-xs">nouveau qcm</button>
		                        </form>

		                        <div class="col-md-12" style="padding-top: 10px;padding-bottom: 10px;">
		                            <form class="form-inline" action="#">
		                                <div class="form-group">
		                                    <input type="text" class="form-control" id="titre-qcm" placeholder="Titre qcm" value=<?php echo '"' . ((isset($libelle)) ? $libelle:'') . '"'; ?>>
		                                </div>
		                                <div class="form-group">
		                                    <input type="text" class="form-control datepicker" id="date-qcm" value=<?php echo '"' . $date . '"'; ?>>
		                                </div>
		                                <?php 
		                                    if(isset($qcm_id)) {
		                                        ?>
		                                        <button type="submit" class="btn btn-warning" id="modifier-qcm">Modifier</button>
		                                        <a class="btn btn-danger" href="?page=qcmqcm" role="button">Annuler</a>
		                                        <input id="qcm_id" name="qcm_id" type="hidden" value=<?php echo '"' . $qcm_id . '"'; ?>>
		                                        <?php
		                                    }
		                                ?>

		                                <button type="submit" class=<?php echo '"' . 'btn btn-success ' . ((isset($qcm_id)) ? 'hidden':'') . '"'; ?> id="create-qcm">Créer</button>

		                                <div class="checkbox">
		                                    <label><input type="checkbox" id="active-qcm"> Activer le qcm</label>
		                                </div>
		                            </form>
		                        </div>
		                    </div>
		                    <table class="table">
		                        <tbody id="list-construction">
		                            <!-- liste des question (chargement) -->
		                            <tr>
		                                <td colspan="2" style="color: red;border-bottom: 1px black;text-align: center;">Ajoutez vos questions pour créer votre QCM. C'est très simple.</td>
		                            </tr>
		                            <?php 
		                                if(isset($qcm_id)) {

		                                    foreach ($lesQuestions as $uneQuestion) {
		                                        ?>
		                                        <tr class="unequestion">
		                                            <td><?php echo $uneQuestion['que_libelle']; ?></td>
		                                            <td class="hidden"><?php echo $uneQuestion['que_id']; ?></td>
		                                            <td><button type="submit" class="btn btn-danger btn-xs" onclick="supprimerUneQuestion(this);">supprimer</button></td>
		                                        </tr>
		                                        <?php
		                                    }

		                                }
		                            ?>
		                        </tbody>
		                    </table> 
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
		<script src="js/qcmqcm.js"></script>
	</div>
</div>