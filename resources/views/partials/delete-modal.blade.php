<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <div class="modal-icon modal-icon-danger">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h3 class="modal-title">Confirm Deletion</h3>
        <p class="modal-text" id="delete-modal-text">Are you sure you want to delete this item? This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
            <form id="delete-modal-form" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(url, itemName) {
    document.getElementById('delete-modal').style.display = 'flex';
    document.getElementById('delete-modal-form').action = url;
    document.getElementById('delete-modal-text').textContent = 'Are you sure you want to delete "' + itemName + '"? This action cannot be undone.';
}
function closeDeleteModal() {
    document.getElementById('delete-modal').style.display = 'none';
}
document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
