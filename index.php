<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Tree App</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Family Tree</h1>
        
        <div id="familyTree" class="family-tree">
            <!-- Family tree will be loaded here -->
        </div>
        
        <button id="addMemberBtn" class="add-member-btn">Add Member</button>
    </div>

    <!-- Add Member Modal -->
    <div id="addMemberModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Add Member</h2>
                <button class="close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="alertContainer"></div>
                
                <form id="addMemberForm">
                    <div class="form-group">
                        <label for="parentSelect">Parent</label>
                        <select id="parentSelect" name="parent_id" class="form-control">
                            <option value="">-- Select Parent --</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="memberName">Name</label>
                        <input type="text" id="memberName" name="name" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalBtn" class="btn btn-secondary">Close</button>
                <button type="submit" id="saveBtn" form="addMemberForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
