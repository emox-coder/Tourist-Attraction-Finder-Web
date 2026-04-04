async function confirmDelete() {
            const id = document.getElementById('deleteId').value;

            try {
                const response = await fetch(`../Backend/routes/api.php?uri=/api/admin/attractions/${id}`, {
                    method: 'DELETE'
                });
                
                const result = await safeJSONParse(response);
                
                if (result.success) {
                    showNotification('Destination deleted successfully', 'success');
                    closeDeleteModal();
                    loadDestinations();
                } else {
                    showNotification('Error deleting destination', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error deleting destination: ' + error.message, 'error');
            }
        }
