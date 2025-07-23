<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Timer</title>
</head>
<body>
<p class = 'minute'>00</p>
<p class = 'minutetext'>minute</p>
<p class = 'seconde'>00</p>
<p class = 'secondetext'>seconde</p>
<script>
    const minute = document.querySelector(".minute");
    const seconde = document.querySelector(".seconde");

    const targettime = new Date();
    targettime.setMinutes(targettime.getMinutes() + 2);


    const timer = setInterval(updatetime, 1000);

    function updatetime() {
        const currenttime = new Date();
        const timedifference = targettime - currenttime;

        if (timedifference <= 0) {
            minute.textContent = "00";
            seconde.textContent = "00";
            clearInterval(timer);
            location.reload()
            return;
        }

        const minutes = Math.floor(timedifference % (1000 * 60 * 60) / (1000 * 60));
        const secondes = Math.floor(timedifference % (1000 * 60) / 1000);

        minute.textContent = minutes.toString().padStart(2, "0");
        seconde.textContent = secondes.toString().padStart(2, "0");
    }

    updatetime();
</script>
</body>
</html>
