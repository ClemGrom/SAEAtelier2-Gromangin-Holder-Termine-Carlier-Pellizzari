<template>
    <body class="lalezar-regular">
        <nav>
            <img src="@/assets/game_logo.jpg" alt="Game Logo" class="game-logo" />
        </nav>

        <div class="gameScore">
            <div class="round"> Round 1/5 </div> <!-- Changer round en fonction de la partie -->
            <div class="scoreText"> Votre score : </div>
            <div class="score"> 5000 </div>  <!-- Changer score en fonction de la partie -->
        </div>

        <footer>
            <div class="continue"> Continuer </div>
            <div class="quit"> X </div>
        </footer>
    </body>
</template>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Lalezar&display=swap');
    .lalezar-regular {
        font-family: "Lalezar", system-ui;
        font-weight: 400;
        font-style: normal;
    }

    body {
        font-family: Arial, sans-serif;
        font-weight: 400;
        background-color: #2c3e50;
        background-image : url('../assets/Nancy_Town_Hall.jpg'); /*Changer l'image en fonction de la partie*/
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        margin: 0;
        padding: 0;
        height: 100vh;
    }

    .game-logo {
        width: 70px;
        height: 70px;
        border-radius: 50%;
    }

    .gameScore {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: calc(75vh - 60px);
    }

    .round {
        font-size: 64px;
        -webkit-text-stroke: 2px #2B80B0;
        color : white;
    }

    .scoreText {
        font-size: 96px;
        -webkit-text-stroke: 2px #2B80B0;
        color : white;
    }

    .score {
        font-size: 128px;
        -webkit-text-stroke: 2px #2B80B0;
        color : white;
    }

    footer {
        background-color: #49658F;
        display: flex;
        justify-content: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    .continue {
        justify-content: center;
        background-color: #2E9C39;
        width : 150px;
        height: 30px;
        border-radius: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        color: white;
        margin-right: 10px;
        text-align: center;
        font-size: 20px;
        margin-top: 25px;
    }

    .quit {
        font-size: 60px;
        color: white;
        margin-left: 10px;
    }

    /* Faire en bootstrap */
</style>