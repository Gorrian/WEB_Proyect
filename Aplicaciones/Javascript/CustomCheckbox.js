function ischecked(ID){
    var Input = document.getElementById(ID+'Return').getAttribute('Value');
    var Image = document.getElementById(ID+'Image');
    if(Input==0){
        Image.setAttribute('hidden',null);
    }else{
        Image.removeAttribute('hidden');
    }
}
function CheckInteract(ID){
    var Input = document.getElementById(ID+'Return');
    var Image = document.getElementById(ID+'Image');

    if(Input.getAttribute("Value")==0){
        Image.removeAttribute('hidden');
        Input.setAttribute('Value',1)
    }else{
        Image.setAttribute('hidden',null);
        Input.setAttribute('Value',0)
    }
}