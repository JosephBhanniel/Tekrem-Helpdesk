<form method="POST" action="create_ticket.php">
  <label for="title">Title:</label>
  <input type="text" name="title" required>
<label for="dept">Department:</label>
<input type="text" name="dept" required>

<label for="category">Category:</label>
<input type="text" name="category" required>

<label for="description">Description:</label>

  <textarea name="description" required></textarea>
<label for="priority">Priority:</label>
<select name="priority" required>
<option value="">Select Priority Level</option>
<option value="Low">Low</option>
<option value="Medium">Medium</option>
<option value="High">High</option>
</select>

<label for="creatorID">Creator ID:</label>
<input type="number" name="creatorID" required>

<button type="submit">Submit</button>

</form>