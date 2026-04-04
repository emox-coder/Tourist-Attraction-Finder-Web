async function handleFormSubmit(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                name: formData.get('name'),
                location: formData.get('location'),
                category: formData.get('category'),
                description: formData.get('description'),
                display_order: parseInt(formData.get('displayOrder')),
                is_top_destination: 1,
                image_url: formData.get('currentImage')
            };

            const id = formData.get('id');
            const url = id ? `../Backend/routes/api.php?uri=/api/admin/attractions/${id}` : '../Backend/routes/api.php?uri=/api/admin/attractions';
            const method = id ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await safeJSONParse(response);

                if (result.success) {
                    showNotification(id ? 'Destination updated successfully' : 'Destination added successfully', 'success');
                    closeModal();
                    loadDestinations();
                } else {
                    showNotification('Error saving destination', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error saving destination: ' + error.message, 'error');
            }
        }

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

        function updateOrder(id, order) {
            fetch(`../Backend/routes/api.php?uri=/api/admin/attractions/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    display_order: parseInt(order)
                })
            })
            .then(response => safeJSONParse(response))
            .then(result => {
                if (result.success) {
                    showNotification('Order updated', 'success');
                }
            })
            .catch(error => console.error('Error:', error));
        }
