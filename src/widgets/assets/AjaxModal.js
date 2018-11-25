/*!
 * Ajax Crud
 * =================================
 * Use for KHanS\Utils\widgets/AjaxGridView extension
 * @author John Martin john.itvn@gmail.com
 */
$(document).ready(function () {

    // Create instance of Modal Remote
    // This instance will be the controller of all business logic of modal
    let modal = new ModalRemote('#ajaxCrudModal');

    // Catch click event on all buttons that want to open a modal
    $(document).on('click', '[role="modal-remote"]', function (event) {
        event.preventDefault();

        // Open modal
        modal.open(this, null);
    });

    // Catch click event on all buttons that want to open a modal
    // with bulk action
    $(document).on('click', '[role="modal-remote-bulk"]', function (event) {
        event.preventDefault();

        // Collect all selected ID's
        var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });
        $('input:radio[name="selection"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            // If no selected ID's show warning
            modal.show();
            modal.setTitle('هیچ گزینه‌ای پیدا نشد.');
            modal.setContent('می‌بایست یک (یا چند) ردیف را پیش از این انتخاب نموده باشید.');
            modal.addFooterButton("ببند", 'button', 'btn btn-info', function (button, event) {
                this.hide();
            });
        } else {
            // Open modal
            modal.open(this, selectedIds);
        }
    });
});
