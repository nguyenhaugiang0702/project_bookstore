<div id="chat-popup">
    <div class="container mt-4">
        <div class="card mx-auto" style="width: 600px;">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="py-2 col-6">
                        BOOKSTORE
                    </div>
                    <div class="col-6 my-auto">
                        <i class="fa-solid fa-xmark float-end" id="close_chat" style="cursor: pointer;"></i>
                    </div>
                </div>
            </div>
            <div class="card-body p-4 border" style="height: 400px; overflow: auto;">
                <div class="chat-box">
                    <div id="chat_load"></div>
                    <div onload="return mess()"></div>
                </div>
            </div>
            <div class="card-footer border">
                <form method="post" class="row" id="typing-sending">
                    <div class="col-10">
                        <input type="hidden" name="sender_id" id="sender_id" value="<?php if (isset($_SESSION['customer_id'])) echo $_SESSION['customer_id'] ?>">
                        <input type="hidden" name="receiver_id" id="receiver_id" value="1">
                        <input type="text" id="typing" name="message" class="form-control border-2 pb-4" placeholder="Nhập để chat">
                    </div>
                    <div class="col-2 my-auto">
                        <button type="submit" onclick="return chat_validation()" class="btn btn-primary" id="sending">
                            <i class="fa fa-paper-plane px-2 py-2" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>
                <div id="msg"></div>
            </div>
        </div>
    </div>
</div>