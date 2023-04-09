<?php
	ob_start();
	if(isset($_SESSION['id'])){
		if($_SESSION['compteValide'] == 1){
			$notification = notificationNombreMembre($_SESSION['id']);
		}else{
			ob_end_flush();
			header('location:attenteValidation.php');
		}
	}else{
		header('location:deconnexion.php');
	}

	if(isset($_POST['cloche'])){
		if($_SESSION['coordinateur'] == 1){
			header('location:notificationSuivi.php');
		}else{
			header('location:notificationMembre.php');
		}
		
	}
?>

<header>
    <div class="ombreVague">
    </div>
    <div class="fondVague">
    </div>
    <div class="menuIcone">
        <div class="icone">
            <button class="menu" onclick="this.classList.toggle('active');this.setAttribute('aria-expanded', this.classList.contains('active'))" aria-label="Main Menu">
            <svg width="35" height="35" viewBox="0 0 100 100">
            <path class="ligne ligne1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
            <path class="ligne ligne2" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
            </svg>
            </button>
        </div>
		<?php
			if(isset($notification)){
				echo'
					<div class="boutonCloche">
						<form action="" method="POST">
							<input type="submit" class="lienInvisible" name="cloche">
						</form>
				';
							if($notification != FALSE){
								echo'
									<div class="rondNotification animationTambour">
										'.$notification.'
									</div>
									<img class="animation" src="../SVG/cloche.svg" alt="Valide"/>
								';
							}else{
								echo'
									<img src="../SVG/cloche.svg" alt="Valide"/>
								';
							}
				echo'
					</div>
				';
			}
		?>
    </div>
    <div class="fondMenu">
        <div class="espaceBlanc100"></div>
		<div class="menuListe">
				<div class="listeLien">
					<svg class="navigation" width="30%" height="30%" viewBox="0 0 834 834" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g id="Mode-Isolation" serif:id="Mode Isolation"></g><g id="Mode-Isolation1" serif:id="Mode Isolation"><path d="M416.883,833.162c-78.513,0 -157.03,0.486 -235.538,-0.18c-48.06,-0.408 -84.055,-22.646 -107.245,-64.843c-9.222,-16.776 -13.283,-35.175 -13.3,-54.218c-0.125,-145.463 -0.361,-290.926 0.137,-436.386c0.139,-40.484 17.068,-73.989 50.793,-96.803c80.198,-54.259 160.54,-108.338 241.848,-160.904c41.382,-26.756 85.636,-26.307 127.018,0.579c80.147,52.07 159.527,105.333 238.785,158.753c35.426,23.879 53.308,57.994 53.308,101.057c-0.005,144.248 0.039,288.493 -0.02,432.74c-0.029,67.264 -52.746,120.02 -120.247,120.166c-78.511,0.169 -157.025,0.039 -235.539,0.039" style="fill:#34383a;fill-rule:nonzero;"/><path d="M415.608,713.459c-36.819,0 -73.642,-0.146 -110.459,0.147c-6.024,0.049 -7.615,-1.611 -7.452,-7.523c0.423,-15.204 0.344,-30.432 0.025,-45.641c-0.103,-4.871 1.413,-6.014 6.109,-6.006c75.16,0.139 150.323,0.144 225.485,-0.005c4.792,-0.01 6.144,1.291 6.049,6.065c-0.298,15.209 -0.408,30.435 0.036,45.638c0.178,6.012 -1.579,7.508 -7.508,7.467c-37.427,-0.278 -74.855,-0.142 -112.285,-0.142" style="fill:#fff;fill-rule:nonzero;"/></g>
					</svg>
					<a class="navigation" href="../Public/accueil.php"><h1 class="headerTitre">Accueil</h1></a>
				</div>
				
				<div class="listeLien">
					<svg class="navigation" width="30%" height="30%" viewBox="0 0 200 200" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
							<g id="Mode-Isolation" serif:id="Mode Isolation" transform="matrix(1,0,0,1,-63.3284,-73.2788)">
								<g transform="matrix(0.586162,0,0,0.586162,163.245,167.691)">
										<path d="M0,180.129C-32.412,180.129 -64.823,180.143 -97.235,180.125C-127.871,180.108 -153.467,159.37 -158.818,129.341C-162.21,110.308 -158.262,91.942 -150.451,74.502C-136.835,44.103 -113.528,23.147 -84.393,8.139C-79.117,5.421 -73.507,3.36 -68.117,0.854C-66.251,-0.014 -65.004,0.41 -63.481,1.626C-41.966,18.815 -17.301,25.974 9.96,23.616C29.85,21.896 47.772,14.589 63.415,2.059C65.388,0.479 66.893,0.172 69.334,1.148C102.073,14.236 128.949,34.356 146.493,65.548C155.868,82.216 160.491,100.226 160.322,119.411C160.061,149.177 137.106,175.298 107.655,179.477C104.297,179.954 100.969,180.124 97.609,180.125C65.072,180.132 32.536,180.129 0,180.129" style="fill:rgb(61,61,61);fill-rule:nonzero;"/>
								</g>
								<g transform="matrix(-0.58614,-0.00509234,-0.00509234,0.58614,162.881,171.526)">
										<path d="M0.391,-167.613C-45.777,-167.997 -83.542,-130.753 -83.909,-84.475C-84.278,-38.083 -46.648,-0.384 0.391,-0.018C45.355,0.331 83.207,-37.098 83.575,-82.27C83.961,-129.708 47.396,-167.222 0.391,-167.613" style="fill:rgb(61,61,61);fill-rule:nonzero;"/>
								</g>
							</g>
					</svg>
					<a class="navigation" href="../Public/compte.php"><h1 class="headerTitre">Compte</h1></a>
				</div>
				<div class="listeLien">
					<svg class="navigation" width="30%" height="30%" viewBox="0 0 834 834" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"><g id="Mode-Isolation" serif:id="Mode Isolation"></g><g id="Mode-Isolation1" serif:id="Mode Isolation"><path d="M833.333,424.751c-3.747,9.486 -10.609,16.568 -17.681,23.632c-92.653,92.544 -185.255,185.139 -277.766,277.825c-8.623,8.638 -18.045,14.944 -30.735,13.393c-19.62,-2.401 -31.251,-16.93 -31.286,-38.78c-0.072,-46.363 -0.186,-92.726 0.154,-139.086c0.052,-6.988 -1.423,-8.895 -8.707,-8.864c-74.287,0.317 -148.576,0.2 -222.864,0.191c-26.774,-0.005 -40.628,-13.787 -40.633,-40.432c-0.011,-63.985 -0.011,-127.973 0,-191.958c0.005,-26.718 13.808,-40.5 40.563,-40.505c74.559,-0.009 149.119,-0.086 223.678,0.147c6.351,0.021 7.982,-1.567 7.942,-7.935c-0.289,-46.631 -0.2,-93.267 -0.135,-139.9c0.033,-21.704 11.136,-35.78 30.415,-38.726c9.368,-1.431 17.66,1.385 24.949,7.204c2.742,2.189 5.212,4.737 7.702,7.226c92.987,92.978 185.937,185.991 278.984,278.905c6.732,6.72 12.709,13.715 15.42,23.017l0,14.646Z" style="fill:#34383a;fill-rule:nonzero;"/><path d="M0.215,416.581c0,-62.093 0.749,-124.198 -0.198,-186.277c-1.08,-70.871 49.347,-128.326 104.613,-146.268c13.974,-4.538 28.248,-7.366 42.938,-7.396c57.756,-0.119 115.512,-0.112 173.265,-0.077c12.459,0.007 18.747,6.264 19.517,18.817c0.63,10.264 1.405,20.45 0.017,30.786c-1.825,13.608 -6.76,18.622 -20.474,18.631c-52.875,0.035 -105.747,0.026 -158.622,0.007c-14.681,-0.007 -29.396,0.555 -42.726,7.375c-31.099,15.912 -49.778,40.78 -49.888,76.473c-0.387,125.271 -0.373,250.542 -0.023,375.814c0.11,39.204 26.951,72.473 64.289,81.477c7.855,1.892 16.005,2.513 24.169,2.504c52.331,-0.056 104.665,-0.038 156.996,-0.01c3.791,0 7.751,-0.399 11.337,0.525c9.085,2.343 14.221,5.138 14.75,15.22c0.626,11.89 1.874,23.721 0.082,35.66c-1.757,11.708 -6.934,16.822 -18.684,16.827c-57.756,0.03 -115.512,0.32 -173.263,-0.107c-72.744,-0.535 -137.46,-58.82 -146.674,-131.042c-1.036,-8.121 -1.388,-16.176 -1.395,-24.286c-0.047,-61.549 -0.026,-123.101 -0.026,-184.653" style="fill:#34383a;fill-rule:nonzero;"/></g>
					</svg>
					<a class="navigation" href="../Public/deconnexion.php"><h1 class="headerTitre">Déconnexion</h1></a>
				</div>
		</div>
	</div>
    <script src="../JS/menu.js"></script>
</header>
