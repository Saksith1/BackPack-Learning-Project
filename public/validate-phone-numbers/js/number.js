const regex = /[0-9^]/;
function validate(e) {
  const chars = e.target.value.split('');
  const char = chars.pop();
  if (!regex.test(char)) {
    e.target.value = chars.join('');
    // console.log(`${char} is not a valid character.`);
  }
}
var el = document.querySelector('#phone');
if(el){
    el.addEventListener('input', validate);
}
