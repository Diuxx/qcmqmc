<?php

	class Utilisateur
	{
		private $id;
		private $nom;
		private $prenom;
		private $login;
		private $password;
		private $mail;
		private $role;

		private $connecter;

		public function __construct() {
			// --
		}

		public function setInfo($id, $nom, $prenom) {
			$this->id = $id;
			$this->nom = $nom;
			$this->prenom = $prenom;
		}

		public function createUtilisateur($nom, $prenom, $type, $password) {
			global $pdo;
			$attr = array(':nom' => $nom,
						  ':prenom' => $prenom,
						  ':password' => $password,
						  ':type' => $type);

			$requete = "INSERT INTO `qcm_utilisateur` VALUES (NULL, :nom, :prenom, :nom, :password, '', :type);";
			$pdoReq = $pdo->prepare($requete);
			return $pdoReq->execute($attr); // --
		}

		public function getId() {
			return $this->id;
		}

		public function getNom() {
			return $this->nom;
		}

		public function getRole() {
			return $this->role;
		}

		public function getPrenom() {
			return $this->prenom;
		}

		public function estConnecter() {
			return ($this->id != null);
		}

		public function deconnection() {
			if($this->estConnecter() && isset($_SESSION['uid'])) {
				unset($_SESSION['uid']);
			}
		}

		public function connect($id, $soleil) {
			global $pdo;	
			$requete = 'SELECT * FROM `qcm_utilisateur`, `qcm_role`
						WHERE `qcm_utilisateur`.fk_uti_role = `qcm_role`.rol_id
						AND `uti_login` = :login
						AND `uti_password` = MD5(:soleil)';
			// préparation de la requete
			$pdoReq = $pdo->prepare($requete);
			$pdoReq->execute(array(':login' => $id, ':soleil' => $soleil));
			$rows = $pdoReq->fetchAll(PDO::FETCH_ASSOC);

			if(sizeof($rows) == 1) // --
			{
				$this->id = $rows[0]['uti_id'];
				$this->nom = $rows[0]['uti_nom'];
				$this->prenom = $rows[0]['uti_prenom'];
				$this->login = $rows[0]['uti_login'];
				$this->password = $rows[0]['uti_password'];
				$this->mail = $rows[0]['uti_mail'];
				$this->role = new Role($rows[0]['rol_id'], $rows[0]['rol_libelle']);
			}
			return (sizeof($rows) == 1);
		}
	}
?>