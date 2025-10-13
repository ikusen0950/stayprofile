<!-- Transfer Modal -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transferModalLabel">Create Transfer Request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="transferForm" method="post" action="/requests/create_transfer">
        <div class="modal-body">
          <div class="mb-3">
            <label for="transfer_type" class="form-label">Transfer Type</label>
            <select class="form-select" id="transfer_type" name="transfer_type" required>
              <option value="Arrival">Arrival</option>
              <option value="Departure">Departure</option>
              <option value="Internal">Internal</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="mode_of_transport" class="form-label">Mode of Transport</label>
            <select class="form-select" id="mode_of_transport" name="mode_of_transport" required>
              <option value="Speedboat">Speedboat</option>
              <option value="Seaplane">Seaplane</option>
              <option value="Domestic Flight">Domestic Flight</option>
              <option value="Car">Car</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="transfer_date" class="form-label">Date</label>
            <input type="date" class="form-control" id="transfer_date" name="transfer_date" required>
          </div>
          <div class="mb-3">
            <label for="transfer_time" class="form-label">Time</label>
            <input type="time" class="form-control" id="transfer_time" name="transfer_time" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Request</button>
        </div>
      </form>
    </div>
  </div>
</div>
