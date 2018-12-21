// function addNewInput(element){
//     if(!element.value){
//         element.parentNode.removeChild( element.nextElementSibling);
//         return;
//     }
//     else if(element.nextElementSibling)
//         return;
//     let newInput = element.cloneNode();
//     let inputType = newInput.id.split('_');
//     newInput.id = inputType + '_' +( parseInt( element.id.substring(element.id.indexOf('_')+1)) + 1);
//     newInput.value= '';
//     element.parentNode.appendChild(newInput);
// }

function addNewInput(element) {
    let parent = element.parentNode;    // div u okviru koga se nalazi
    let hasValue = false;
    for(let i = 0; i < parent.children.length; i++) {
        if(parent.children[i].value) {
            hasValue = true;
            break;
        }
    }
    if (!hasValue) {
        if(parent.parentNode.children.length === 1) {
            return;
        } else {
            parent.parentNode.removeChild(parent);
            return;
        }
    } else if (parent.nextElementSibling)
        return;

    let newInput = parent.cloneNode(); // novi div
    let nameParts = newInput.id.split('_');
    newInput.id = nameParts[0] + '_' + (parseInt(nameParts[1]) + 1);
    for(let i = 0; i < parent.children.length; i++) {
        let newChild;
        if(parent.children[i].type === "select-one") {
            newChild = parent.children[i].cloneNode(true);  // cloneNode([deep])

        } else {
            newChild = parent.children[i].cloneNode();
        }
        let nameParts = newChild.name.split('_');
        let name = nameParts[0] + '_' + nameParts[1] + '_' + (parseInt(nameParts[2]) + 1);
        newChild.name = name;
        newChild.value = "";
        newInput.appendChild(newChild);
    }
    parent.parentNode.appendChild(newInput);
}