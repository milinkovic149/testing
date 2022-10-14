const btns = document.querySelectorAll('button[type=btn]');

for(var i = 0, len = btns.length; i < len; i++) {
    btns[i].addEventListener('click', function(e){
        window.location.href = "index.php?w1=" + e.target.id;
    })
  }


