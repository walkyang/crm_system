$(document).ready(function () {
    
    success_redirect();
    
    function success_redirect(){
        var url = $("#success_url").val();
        if(url != ''){
            var loginTime = parseInt($('.loginTime').text());
            var time = setInterval(function(){
                loginTime = loginTime-1;
                $('.loginTime').text(loginTime);
                if(loginTime==0){
                    clearInterval(time);
                    window.location.href=url;
                }
            },1000);
        }
    }

    $(".alert-danger").fadeTo(5000).hide(5000);
});