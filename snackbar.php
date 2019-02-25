<div class="mdc-snackbar">
  <div class="mdc-snackbar__surface">
    <div class="mdc-snackbar__label" role="status" aria-live="polite">

    </div>
    <div class="mdc-snackbar__actions">
      <button class="mdc-icon-button mdc-snackbar__dismiss material-icons" title="Dismiss">close</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  var snackbar = document.querySelector('.mdc-snackbar');
  var mdcSnackbar = new mdc.snackbar.MDCSnackbar(snackbar);
  function showSnackbar(text, time=5, actionButtonText=null, actionURL=null){
    mdcSnackbar.labelText = text;
    mdcSnackbar.timeoutMs = time * 1000;
    var action = snackbar.querySelector('.mdc-snackbar__action');
    if(action) {
      var actions = snackbar.querySelector('.mdc-snackbar__actions');
      actions.removeChild(action);
    }
    if(actionButtonText) {
      var actions = snackbar.querySelector('.mdc-snackbar__actions');
      button = document.createElement('button');
      button.setAttribute('type', 'button');
      button.setAttribute('class', 'mdc-button mdc-snackbar__action');
      button.setAttribute('onclick', 'window.location.href="' + actionURL + '"');
      button.textContent = actionButtonText;
      actions.prepend(button);
    }
    mdcSnackbar.open();
  }
</script>
