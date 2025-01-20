<header>
<!--header de la page d'accueil-->
	<div id="main_header_container">
    	<h1>Le Carré d’As</h1>
		<img>logo</img>
    <!--verifier si connecter avec session, renvoyer vers sign_in, une fois co affiché info user-->
		<?php 
        /** vérif de l'état de l'utilisateur pour afficher ses infos si connecter*/
		if(SessionStatus === true){
			include_once("carredas/templates/headers/info_login/User_header.php");
		}
            /* affichage info User*/ //include_once(------------------) => profil (fichier header avec profil)
        

		else {
			include_once("carredas/templates/headers/info_login/defaut_header.php");
		}
			/*lance headers/notconnect.php ==> link > sign up or sign in*/ //include_once(---------) => not assign (fichier header sans profil)
		;


   



		?>
        
	</div>
</header>