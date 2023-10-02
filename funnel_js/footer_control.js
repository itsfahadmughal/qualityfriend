var impressum_url = document.getElementById('impressum_url');
impressum_url.addEventListener('change', function() {
    var  impress   = document.getElementById('impress');
    impress.setAttribute("href", document.getElementById('impressum_url').value);

});
var data_url = document.getElementById('data_url');
data_url.addEventListener('change', function() {
    var  data_policy   = document.getElementById('data_policy');
    data_policy.setAttribute("href", document.getElementById('data_url').value);

});
var open_policy = document.getElementsByClassName("open_policy");
//button change color
var show_tools_footer = function() {
    var attribute = this.getAttribute("data-myattribute");
    var id_is = this.id;

    open_ideal();
    selected_text_id = id_is;
    just_hide_leftpage();
    alltools('for_only_footer');
    var  impress   = document.getElementById('impress');
    var  data_policy   = document.getElementById('data_policy');

    var impress =  impress.getAttribute("href");

    var data =  data_url.getAttribute("href");



    document.getElementById('impressum_url').value  = impress ;
    document.getElementById('data_url').value = data_policy;




}



footer_open_run();
function footer_open_run() {
    for (var i = 0; i < open_policy.length; i++) {
        open_policy[i].addEventListener('click', show_tools_footer, false);


    }
}