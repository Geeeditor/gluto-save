
    var animation1 = bodymovin.loadAnimation({
        container: document.getElementById('lottie-pending'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '../animations/creditcard.json'
    });

    var animation2 = bodymovin.loadAnimation({
        container: document.getElementById('lottie-approved'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '../animations/dashboard.json'
    });

    var animation3 = bodymovin.loadAnimation({
        container: document.getElementById('lottie-failed'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '../animations/failed.json'
    });

