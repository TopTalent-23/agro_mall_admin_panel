   <div class="modal fade" id="cod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cash On Delivery</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <div class="modal-body">
    <form action="" method="POST">
        <div class="row mb-3">
            <div class="col-6 text-start">
                <strong>For Cash on Delivery:</strong> Rs.20/- Per Kilometer
            </div>
            <div class="col-6 text-end">
                <button type="button" onclick="processCashOnDelivery()" class="btn btn-success">Confirm</button>
            </div>
        </div>
        <div class="row">
            <div class="col-6 text-start">
                <strong>For Online Payment:</strong> Rs.10/- Per Kilometer
            </div>
            <div class="col-6 text-end">
                <button type="button" class="btn btn-success" onclick="pay_now()">Pay Now</button>
            </div>
        </div>
    </form>
</div>

      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>