

document.addEventListener('DOMContentLoaded', function(){	
      
    window.addEventListener('scroll', function(e) {
        scrollFunction()
    });
    

    let top = document.getElementById('top');
    let logout = document.getElementById('logout');

    if(top !== undefined && logout !== undefined) {
        document.getElementById('top').addEventListener('click', function(e) {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        });
    
        document.getElementById('logout').addEventListener('click', function(e) {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        });
    }
});

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementById('top').style.display = 'block';
    } else {
      document.getElementById('top').style.display = 'none';
    }
}


  