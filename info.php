<?php
session_start();

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'volan_app';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);} 
catch(PDOException $e) {
    die("Kapcsolódási hiba: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Volán Szervezeti Információs Lap</title>
    <style>

:root {
            --primary-color:linear-gradient(to right, #211717,#b30000);
            --accent-color: #FB5300;
            --text-light: #FFFFFF;
            --shadow: 0 5px 10px rgba(0,0,0,0.8);
            --secondary-color: #3498db;
            --hover-color: #2980b9;
            --background-light: #f8f9fa;
            --text-light: #ffffff;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            text-align: justify;
            font-family: 'Segoe UI',tahoma,Geneva, Verdana, sans-seriff;
            background-color: #f5f5f5;
            color: #000;
            min-height: 100vh;
            
        }
        .header {
    position: relative;
    background: var(--primary-color);
    color: var(--text-light);
    padding: 1rem;
    box-shadow: 0 2px 10px var(--shadow-color);
}

.header h1 {
    margin: 0;
    text-align: center;
    font-size: 2rem;
    padding: 1rem 0;
}

.nav-wrapper {
    position: absolute;
    top: 1rem;
    left: 1rem;
    z-index: 1000;
}

.nav-container {
    position: relative;
}

.menu-btn {
    background: none;
    border: none;
    border-radius: 8px;
    padding: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px var(--shadow-color);
}

.menu-btn:hover {
    background: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px var(--shadow-color);
}

.hamburger {
    position: relative;
    width: 30px;
    height: 20px;
}

.hamburger span {
    position: absolute;
    width: 100%;
    height: 3px;
    background: var(--text-light);
    border-radius: 3px;
    transition: all 0.3s ease;
}

.hamburger span:nth-child(1) { top: 0; }
.hamburger span:nth-child(2) { top: 50%; transform: translateY(-50%); }
.hamburger span:nth-child(3) { bottom: 0; }

.menu-btn.active .hamburger span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.menu-btn.active .hamburger span:nth-child(2) {
    opacity: 0;
}

.menu-btn.active .hamburger span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

.dropdown-menu {
    position: absolute;
    top: calc(100% + 1rem);
    left: 0;
    background: var(--text-light);
    border-radius: 12px;
    min-width: 280px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-20px);
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    box-shadow: 0 10px 30px var(--shadow-color);
    overflow: hidden;
}

.dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.menu-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.menu-items li {
    transform: translateX(-100%);
    opacity: 0;
    transition: all 0.3s ease;
}

.dropdown-menu.active .menu-items li {
    transform: translateX(0);
    opacity: 1;
}

.menu-items li:nth-child(1) { transition-delay: 0.1s; }
.menu-items li:nth-child(2) { transition-delay: 0.2s; }
.menu-items li:nth-child(3) { transition-delay: 0.3s; }
.menu-items li:nth-child(4) { transition-delay: 0.4s; }
.menu-items li:nth-child(5) { transition-delay: 0.5s; }

.menu-items a {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: black;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.menu-items a:hover {
    background: linear-gradient(to right, #211717,#b30000);
    color: white;
    padding-left: 2rem;
}

.menu-items a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: darkred;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.menu-items a:hover::before {
    transform: scaleY(1);
}

.menu-items a img {
    width: 24px;
    height: 24px;
    margin-right: 12px;
    transition: transform 0.3s ease;
}

.menu-items a:hover img {
    transform: scale(1.2) rotate(5deg);
}

.menu-items a span {
    font-size: 17px;
}


.menu-items a.active {
    background: white;
    color: black;
    font-weight: 600;
}

.menu-items a.active::before {
    transform: scaleY(1);
}

@keyframes ripple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(2);
        opacity: 0;
    }
}

.menu-items a::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: gray;
    left: 0;
    top: 0;
    transform: scale(0);
    opacity: 0;
    pointer-events: none;
    transition: all 0.5s ease;
}

.menu-items a:active::after {
    animation: ripple 0.6s ease-out;
}
       
    
      
      #map{
        margin-top: 5%;  
        }
        a
        {
            font-weight: bold;
            font-size 10%;
        }
        footer {
            background: var(--primary-color);
            color: var(--text-light);
            padding: 3rem 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .footer-section h2 {
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: var(--text-light);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--accent-color);
        }
a{
    color: gray;
}
    </style>
</head>
<body>
<div class="header">
    <div class="nav-wrapper">
        <div class="nav-container">
            <button class="menu-btn" id="menuBtn">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <nav class="dropdown-menu" id="dropdownMenu">
                <ul class="menu-items">
                    <li>
                        <a href="index.php" class="active">
                            <img src="placeholder.png" alt="Főoldal">
                            <span>Főoldal</span>
                        </a>
                    </li>
                    <li>
                        <a href="buy.php">
                            <img src="tickets.png" alt="Jegyvásárlás">
                            <span>Jegyvásárlás</span>
                        </a>
                    </li>
                    <li>
                        <a href="menetrend.php">
                            <img src="calendar.png" alt="Menetrend">
                            <span>Menetrend</span>
                        </a>
                    </li>
                    <li>
                        <a href="info.php">
                            <img src="information-button.png" alt="Információ">
                            <span>Információ</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Kijelentkezés</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
            <h1><i class="fas fa-map-marked-alt"></i> Szervezeti Információk</h1>
        </div>
    <main>
       

        <section id="about" class="card" style="font-weight: bold; font-style: italic; text-align:center">
            <ul>
                
                <li><i id="atlat" class="fas fa-balance-scale"></i> Átláthatóság</li>
                <li><i id="kozszo"class="fas fa-users"></i> Közszolgáltatás</li>
                <li><i id="mino"class="fas fa-check-circle"></i> Minőség</li>
            </ul>
        </section>

        <section id="documents" class="card">
    <h2 style="text-align:center">Dokumentumok</h2><br>

    <h3 style="text-align:center">A 2009. évi CXXII. törvény 2.§ (1) - (2) bek. alapján közzététel</h3>
        <ul>
        <li>
            <ul>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20110101-1.pdf">Vezető tisztségviselők illetménye 2011.01.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20110701.pdf">Vezető tisztségviselők illetménye 2011.07.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20120101.pdf">Vezető tisztségviselők illetménye 2012.01.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20120301.pdf">Vezető tisztségviselők illetménye 2012.03.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20120901.pdf">Vezető tisztségviselők illetménye 2012.09.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20130101.pdf">Vezető tisztségviselők illetménye 2013.01.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20130701.pdf">Vezető tisztségviselők illetménye 2013.07.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20140531.pdf">Vezető tisztségviselők illetménye 2014.05.31.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20150101.pdf">Vezető tisztségviselők illetménye 2015.01.01.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20160826.pdf">Vezető tisztségviselők illetménye 2016.08.26.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20170424.pdf">Vezető tisztségviselők illetménye 2017.04.24.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT-20180103.pdf">Vezető tisztségviselők illetménye 2018.01.03.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KK-Zrt-Közzététel-20190228.pdf">Vezető tisztségviselők illetménye 2019.02.28.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KK-Zrt-Közzététel-20190620.pdf">Vezető tisztségviselők illetménye 2019.06.20.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KK-Zrt-Közzététel-200311.pdf">Vezető tisztségviselők illetménye 2020.03.11</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KK_Zrt_Kozzetetel_20220412.pdf">Vezető tisztségviselők illetménye 2022.04.12.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KK-Zrt-Közzététel-20230310.pdf">Vezető tisztségviselők illetménye 2023.03.01.</a></li>
                        
                    </ul>
</section>
<section id="documents" class="card">
                    <h3 style="text-align:center">A 2009. évi CXXII. törvény 2.§ (3) - (4) bek. alapján közzététel</h3>
            </ul>
            <ul>
                <li><a href="Beszerzések-2.sz_.-melléklet-2.pdf">Szerződések 2017</a></li>
                <li><a href="#public-service">Közszolgáltatási szerződés 2013.01.01.</a>
                    <ul>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz1m.pdf">1. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz2m.pdf">2. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz3m.pdf">3. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz4m.pdf">4. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz5m.pdf">5. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz6m.pdf">6. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz7m.pdf">7. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz8m.pdf">8. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz9m.pdf">9. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz10m.pdf">10. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/ksz11m.pdf">11-12. sz. melléklet</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-1.-sz.-módosítás.pdf">Közszolgáltatási szerződés 1. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-2.-sz.-módosítás.pdf">Közszolgáltatási szerződés 2. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-3.-sz.-módosítás.pdf">Közszolgáltatási szerződés 3. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-4.-sz.-módosítás.pdf">Közszolgáltatási szerződés 4. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-5.-sz.-módosítás.pdf">Közszolgáltatási szerződés 5. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolg.szerz_.-6.-sz.-módosítás.pdf">Közszolgáltatási szerződés 6. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolgáltatási-szerződés-7.sz_.-módosítás.pdf">Közszolgáltatási szerződés 7. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolgáltatási-szerződés-11.-sz.-mód.pdf">Közszolgáltatási szerződés 11. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolgáltatási-szerződés-12.-sz.-módosítása.pdf">Közszolgáltatási szerződés 12. sz. módosítás</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közszolgáltatási-szerződés-13.-sz.-módosítása-002.pdf">Közszolgáltatási szerződés 13. sz. módosítás</a></li>
                    </ul>

                    </section>
            <section id="documents" class="card">
                <h2 style="text-align:center">Közzététel</h2><br>
                    <ul>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Kapos-Holding-Zrt.-Adatvédelmi-Szabályzat-20191120-compressed.pdf">Adatvédelmi szabályzat</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/SZMSZ_2023.pdf">Szervezeti és működési szabályzat</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Szervezeti-ábra.pdf">Szervezeti ábra</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Panaszkezelési szabályzat">Panaszkezelési szabályozat</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Kapos%20Holding-Szervezeti%20integritást%20sértő%20panaszok%20kezelésének%20szabályozása.pdf">Szervezeti integritást sértő panaszok kezelésének szabályozása</a>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közzétételi%20Szabályzat_20240201.pdf">Közzétételi Szabályzat</a></li>

                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Energetikai_jelentes_2017.pdf">Energetikai jelentés 2017.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/energetika2018.pdf">Energetikai jelentés 2018.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/energetika-2019.pdf">Energetikai jelentés 2019.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Éves_2020_Közlekedési_aláírt.pdf">Energetikai jelentés 2020.</a></li>
                        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/20180821091132548.pdf">Á.SZ. jelentés</a></li>


                    </ul>
</section>


<section id="procurement" class="card">
    <h2 style="text-align:center">Közbeszerzés</h2><br>
    <ul>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/statisztikai-osszegzes-2015-2.pdf">2015. évi statisztikai összegzés</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Kaposvari-Kozlekedesi-Zrt.pdf">2016. évi közbeszerzések</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/statisztikai_osszegezes_2016-1.pdf">2016. évi statisztikai összegzés</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/kozbeszerzesi_terv_2017-1.pdf">2017. évi közbeszerzési terv</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/statisztikai-osszegezes-2017-1.pdf">2017. évi statisztikai összegzés</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/kozbeszerzesi_terv_2018-2.pdf">2018. évi közbeszerzési terv</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2018.-évi-Közbeszerzési-terv.pdf">2018. évi közbeszerzési terv (módosított)</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közbeszerzési-terv-2019.pdf">2019. évi közbeszerzési terv</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/STATISZTIKAI-ÖSSZEGEZÉS-2019-KK-Zrt.pdf">2019. évi statisztikai összegzés</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2020.-évi-közbeszerzési-terv.pdf">2020. évi közbeszerzési terv</a></li>
    </ul>
</section>



<section id="documents" class="card">
    <h2 style="text-align:center">Foglalkoztatotti adatok</h2><br>
    <ul>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT_kozerdeku_adatok_2015.pdf">Foglalkoztatotti adatok 2015</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT_kozerdeku_adatok_2016_I_NE.pdf">Foglalkoztatotti adatok 2016. I. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT_kozerdeku_adatok_2016_II_NE.pdf">Foglalkoztatotti adatok 2016. II. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KTRT_kozerdeku_adatok_2016_III_NE.pdf">Foglalkoztatotti adatok 2016. III. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közérdekű_2016_IV.pdf">Foglalkoztatotti adatok 2016. IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2017_I_NE.pdf">Foglalkoztatotti adatok 2017. I. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2017_II_NE.pdf">Foglalkoztatotti adatok 2017. II. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2017_III_NE.pdf">Foglalkoztatotti adatok 2017. III. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2017_IV_NE.pdf">Foglalkoztatotti adatok 2017. IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2018_I_NE.pdf">Foglalkoztatotti adatok 2018. I. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2018_II_NE.pdf">Foglalkoztatotti adatok 2018. II. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKZRT_kozerdeku_adatok_2018_III_NE.pdf">Foglalkoztatotti adatok 2018. III. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/KKözlekedési-IV.-negyedéves-közzététel.pdf">Foglalkoztatotti adatok 2018. IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2019-I-negyedév-közzététel.pdf">Foglalkoztatotti adatok 2019. I. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2019-II-negyedév-közzététel-KK-Zrt.pdf">Foglalkoztatotti adatok 2019. II. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2019-negyedéves-közzététel-közlekedési.pdf">Foglalkoztatotti adatok 2019. III. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2019-negyedéves-közzététel-közlekedési.pdf">Foglalkoztatotti adatok 2019. IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közlekedési-2020-I-II-III-IV.-Negyedéves-közzététel.pdf">Foglalkoztatotti adatok 2020. I-IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közlekedési%202021.%20I-II-III-IV.%20negyedévi%20közzététel.pdf">Foglalkoztatotti adatok 2021. I-IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közlekedési-2022.-I-IV.-negyedévi-közzététel.pdf">Foglalkoztatotti adatok 2022. I-IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közlekedési%20-%202023.%20I-IV.%20negyedévi%20közzététel.pdf">Foglalkoztatotti adatok 2023. I-IV. negyedév</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Közlekedési%20-%202024.%20I.%20negyedévi%20közzététel.pdf">Foglalkoztatotti adatok 2024. I. negyedév</a></li>
    </ul>
</section>



<section id="reports" class="card">
    <h2 style="text-align:center">Beszámolók</h2><br>
    <ul>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/20160824095952231.pdf">2015. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/20180817114300492.pdf">2016. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/20180817113901683.pdf">2017. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2018.-évi-Beszámoló-honlapra-2.pdf">2018. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2019.-évi-beszámoló-honlapra.pdf">2019. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Beszámoló-2020.pdf">2020. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/2021.-évi-Beszámoló.pdf">2021. évi beszámoló</a></li>
        <li><a href="https://www.kaposbusz.hu/static/files/oldalak/Éves-Beszámoló-2022.pdf">2022. évi beszámoló</a></li>
    </ul>
</section>



<section id="about" class="card" style="font-weight: bold; color: gray">
            <ul>
                <h2 style="text-align:center">Üzletszabályzat</h2><br>
                <li></i>Aktuális üzletszabályzat:Érvényes 2022. október 17-től</li>
              <br>
                <h4>Korábbi üzletszabályzatok:</h4><br>

                <li></i>Érvényes  2020. szeptember 21-től</li>
                <li></i>Érvényes 2020. január 1-től </li>
                <li></i> Érvényes 2019. január 1-től</li>
                <li></i> Érvényes 2018. január 1-től</li>
            </ul>
        </section>

        <section style="font-style: italic" id="contacts" class="card">
            <h2 style="text-align:center" id="eler">Elérhetőségek</h2>
            <ul>
                <li><i class="fas fa-phone"></i> +36-82/411-850</li>
                <li><i class="fas fa-envelope"></i> titkarsag@kkzrt.hu</li>
                <li><i class="fas fa-map-marker-alt"></i> 7400 Kaposvár, Cseri út 16.</li>
                <li><i class="fas fa-map-marker-alt"></i> Áchim András utca 1.</li>


                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2753.752828799859!2d17.785107176739764!3d46.354449773601026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476815fb4c7fae55%3A0x2527be16dba52f77!2zS2Fwb3N2w6FyLCDDgWNoaW0gQW5kcsOhcyB1LiAxLCA3NDAw!5e0!3m2!1shu!2shu!4v1731483865822!5m2!1shu!2shu" width="100%" height="40%" style="border:0;" allowfullscreen="" loading="lazy" id="map" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </ul>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h2>Kaposvár közlekedés</h2>
                <p style="font-style: italic">Megbízható közlekedési szolgáltatások<br> az Ön kényelméért már több mint 50 éve.</p><br>
                <div class="social-links">
                    <a style="color: darkblue;" href="https://www.facebook.com/VOLANBUSZ/"><i class="fab fa-facebook"></i></a>
                    <a style="color: lightblue"href="https://x.com/volanbusz_hu?mx=2"><i class="fab fa-twitter"></i></a>
                    <a style="color: red"href="https://www.instagram.com/volanbusz/"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
           
            <div  class="footer-section">
                <h3>Elérhetőség</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-phone"></i> +36-82/411-850</li>
                    <li><i class="fas fa-envelope"></i> titkarsag@kkzrt.hu</li>
                    <li><i class="fas fa-map-marker-alt"></i> 7400 Kaposvár, Cseri út 16.</li>
                    <li><i class="fas fa-map-marker-alt"></i> Áchim András utca 1.</li>
                </ul>
            </div>
        </div>
        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>© 2024 Kaposvár közlekedési Zrt. Minden jog fenntartva.</p>
        </div>
    </footer>
    <script>
const toggle = document.getElementById('toggle')
        const nav = document.getElementById('nav')

        toggle.addEventListener('click', () => nav.classList.toggle('active'))
    </script>
</body>
</html>