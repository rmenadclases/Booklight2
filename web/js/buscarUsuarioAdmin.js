//Change active to user tag when searching
    document.getElementById('tab1').classList.remove('active');
    document.getElementById('tab2').classList.add('active');
    document.getElementById('tab2').classList.remove('fade');
    var firstTabLink = document.querySelector('#tab1-tab');
    firstTabLink.classList.remove('active');
    var secondTabLink = document.querySelector('#tab2-tab');
    secondTabLink.classList.add('active');