var Id = 0;
var commentContentElement = null;

var openmodal = document.querySelectorAll('.modal-open');
for (var i = 0; i < openmodal.length; i++) {
  openmodal[i].addEventListener('click', function(event){
    event.preventDefault();

    commentContentElement = event.target.parentNode.parentNode.childNodes[1];
    var commentContent = commentContentElement.textContent;
    Id = event.target.parentNode.parentNode.dataset['commentid'];
    $('#comment-body').val(commentContent);
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
        data: { commentContent: $('#comment-body').val(), Id: Id, _token: token}
    })
    .done(function (msg) {
        $(commentContentElement).text(msg['new_body']);
    });
});