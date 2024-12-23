<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Equipment Management</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    include 'koneksi.php';
    $conn = new Koneksi();
    $equipment = $conn->getEquipment();
    ?>

    <div class="container">
        <h2>Medical Equipment Management</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>

        <button onclick="document.getElementById('addModal').style.display='block'" class="add-button">Add
            Equipment</button>

        <!-- Modal Tambah Equipment -->
        <div id="addModal" class="modal">
            <div class="modal-content">
                <span onclick="document.getElementById('addModal').style.display='none'" class="close">&times;</span>
                <h3>Add New Equipment</h3>
                <form method="POST" action="koneksi.php">
                    <input type="hidden" name="action" value="addEquipment">

                    <label for="equipment_code">Equipment Code:</label>
                    <input type="text" name="equipment_code" required>

                    <label for="name">Equipment Name:</label>
                    <input type="text" name="name" required>

                    <label for="category">Category:</label>
                    <select name="category" required>
                        <option value="">Select Category</option>
                        <option value="Diagnostic">Diagnostic</option>
                        <option value="Monitoring">Monitoring</option>
                        <option value="Therapeutic">Therapeutic</option>
                        <option value="Life Support">Life Support</option>
                        <option value="Laboratory">Laboratory</option>
                    </select>

                    <label for="manufacturer">Manufacturer:</label>
                    <input type="text" name="manufacturer" required>

                    <label for="purchase_date">Purchase Date:</label>
                    <input type="date" name="purchase_date" required>

                    <label for="warranty_expiry">Warranty Expiry:</label>
                    <input type="date" name="warranty_expiry" required>

                    <label for="maintenance_status">Maintenance Status:</label>
                    <select name="maintenance_status" required>
                        <option value="operational">Operational</option>
                        <option value="maintenance">Under Maintenance</option>
                        <option value="retired">Retired</option>
                    </select>

                    <label for="location">Location:</label>
                    <input type="text" name="location" required>

                    <label for="last_inspection_date">Last Inspection Date:</label>
                    <input type="date" name="last_inspection_date" required>

                    <label for="notes">Notes:</label>
                    <textarea name="notes" rows="4"></textarea>

                    <button type="submit">Add Equipment</button>
                </form>
            </div>
        </div>

        <!-- Daftar Equipment -->
        <div class="table-container">
            <h3>Equipment List</h3>
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Manufacturer</th>
                        <th>Status</th>
                        <th>Location</th>
                        <th>Last Inspection</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($equipment as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['equipment_code']); ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td><?php echo htmlspecialchars($item['manufacturer']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower($item['maintenance_status']); ?>">
                                <?php echo htmlspecialchars($item['maintenance_status']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($item['location']); ?></td>
                        <td><?php echo date('Y-m-d', strtotime($item['last_inspection_date'])); ?></td>
                        <td>
                            <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($item)); ?>)"
                                class="edit-button">Edit</button>
                            <button
                                onclick="openDeleteModal(<?php echo $item['id']; ?>, '<?php echo htmlspecialchars($item['name']); ?>')"
                                class="delete-button">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Edit Equipment -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span onclick="document.getElementById('editModal').style.display='none'" class="close">&times;</span>
                <h3>Edit Equipment</h3>
                <form method="POST" action="koneksi.php">
                    <input type="hidden" name="action" value="editEquipment">
                    <input type="hidden" name="id" id="edit_id">

                    <label for="edit_equipment_code">Equipment Code:</label>
                    <input type="text" name="equipment_code" id="edit_equipment_code" required>

                    <label for="edit_name">Equipment Name:</label>
                    <input type="text" name="name" id="edit_name" required>

                    <label for="edit_category">Category:</label>
                    <select name="category" id="edit_category" required>
                        <option value="">Select Category</option>
                        <option value="Diagnostic">Diagnostic</option>
                        <option value="Monitoring">Monitoring</option>
                        <option value="Therapeutic">Therapeutic</option>
                        <option value="Life Support">Life Support</option>
                        <option value="Laboratory">Laboratory</option>
                    </select>

                    <label for="edit_manufacturer">Manufacturer:</label>
                    <input type="text" name="manufacturer" id="edit_manufacturer" required>

                    <label for="edit_purchase_date">Purchase Date:</label>
                    <input type="date" name="purchase_date" id="edit_purchase_date" required>

                    <label for="edit_warranty_expiry">Warranty Expiry:</label>
                    <input type="date" name="warranty_expiry" id="edit_warranty_expiry" required>

                    <label for="edit_maintenance_status">Maintenance Status:</label>
                    <select name="maintenance_status" id="edit_maintenance_status" required>
                        <option value="operational">Operational</option>
                        <option value="maintenance">Under Maintenance</option>
                        <option value="retired">Retired</option>
                    </select>

                    <label for="edit_location">Location:</label>
                    <input type="text" name="location" id="edit_location" required>

                    <label for="edit_last_inspection_date">Last Inspection Date:</label>
                    <input type="date" name="last_inspection_date" id="edit_last_inspection_date" required>

                    <label for="edit_notes">Notes:</label>
                    <textarea name="notes" id="edit_notes" rows="4"></textarea>

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Delete -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span onclick="document.getElementById('deleteModal').style.display='none'" class="close">&times;</span>
                <h3>Confirm Delete</h3>
                <p>Are you sure you want to delete equipment: <span id="deleteTitle"></span>?</p>
                <form method="POST" action="koneksi.php">
                    <input type="hidden" name="action" value="deleteEquipment">
                    <input type="hidden" id="deleteId" name="id">
                    <div class="modal-buttons">
                        <button type="submit" class="delete-button">Yes, Delete</button>
                        <button type="button" onclick="document.getElementById('deleteModal').style.display='none'"
                            class="cancel-button">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openEditModal(item) {
        document.getElementById('edit_id').value = item.id;
        document.getElementById('edit_equipment_code').value = item.equipment_code;
        document.getElementById('edit_name').value = item.name;
        document.getElementById('edit_category').value = item.category;
        document.getElementById('edit_manufacturer').value = item.manufacturer;
        document.getElementById('edit_purchase_date').value = item.purchase_date;
        document.getElementById('edit_warranty_expiry').value = item.warranty_expiry;
        document.getElementById('edit_maintenance_status').value = item.maintenance_status;
        document.getElementById('edit_location').value = item.location;
        document.getElementById('edit_last_inspection_date').value = item.last_inspection_date;
        document.getElementById('edit_notes').value = item.notes;

        document.getElementById('editModal').style.display = 'block';
    }

    function openDeleteModal(id, name) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteTitle').textContent = name;
        document.getElementById('deleteModal').style.display = 'block';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
    </script>

    <style>
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.9em;
        font-weight: bold;
    }

    .status-operational {
        background-color: #4CAF50;
        color: white;
    }

    .status-maintenance {
        background-color: #FFC107;
        color: black;
    }

    .status-retired {
        background-color: #F44336;
        color: white;
    }

    .modal-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .add-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        margin-bottom: 20px;
    }

    .edit-button {
        background-color: #2196F3;
        color: white;
    }

    .delete-button {
        background-color: #F44336;
        color: white;
    }

    .cancel-button {
        background-color: #757575;
        color: white;
    }

    .table-container {
        margin-top: 20px;
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .modal-content {
        max-width: 600px;
        width: 100%;
    }

    .modal-content form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    input,
    select,
    textarea {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    textarea {
        resize: vertical;
    }
    </style>
</body>

</html>