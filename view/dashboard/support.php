<div class="row">
    <div class="col-md-12 userpanel p-3">
    <p>Live Support</p>
        <textarea name="liveMessage" id="liveMessage" class="col-lg-12 input-lg"></textarea>
        <div class="form-group d-flex flex-column">
            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                <div class="row">
                    <div class="col-md-11">
                        <textarea name="sendLiveMessage" id="sendLiveMessage" class="col-lg-12 input-lg"></textarea>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="" name="send">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>