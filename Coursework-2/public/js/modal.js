var Id = 0;
var postContentElement = null;

var openmodal = document.querySelectorAll('.modal-open');
for (var i = 0; i < openmodal.length; i++) {
  openmodal[i].addEventListener('click', function(event){
    event.preventDefault();

    postContentElement = event.target.parentNode.parentNode.childNodes[1];
    var postContent = postContentElement.textContent;
    Id = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postContent);
    toggleModal();
  });
};
    
const overlay = document.querySelector('.modal-overlay');
overlay.addEventListener('click', toggleModal);
    
var closemodal = document.querySelectorAll('.modal-close');
for (var i = 0; i < closemodal.length; i++) {
  closemodal[i].addEventListener('click', toggleModal);
};
    
function toggleModal () {
  const body = document.querySelector('body');
  const modal = document.querySelector('.modal');
  modal.classList.toggle('opacity-0');
  modal.classList.toggle('pointer-events-none');
  body.classList.toggle('modal-active');
};

$('#modal-save').on('click', function () {
    $.ajax({
        method: 'POST',
        url: url,
        data: { postContent: $('#post-body').val(), Id: Id, _token: token}
    })
    .done(function (msg) {
        $(postContentElement).text(msg['new_body']);
    });
});