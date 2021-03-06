    <div class="modal fade" id="modalWithdraw" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded justify-content-center">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="modalTitle">Withdraw cash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="withdrawMsg">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalMoneyFail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded justify-content-center">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="modalMoneyFailTitle">Not enough money</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="modalMoneyFailMsg">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalIbanFail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow p-3 mb-5 bg-white rounded justify-content-center">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="modalIbanFailTitle">Iban required</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-dark" id="modalIbanFailMsg">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm shadow p-3 mb-5 bg-white rounded text-dark text-left">
        <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
            <div class="form-group">
                <div class="row align-content-center justify-content-between">
                    <div class="col-sm userpanel p-3">
                        <p class="h4 text-center">User Account Settings</p>
                        <div class="row mr-auto ">
                            <div class="col-sm-1">
                                <label>IBAN: </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="iban" class="col-sm-12 input-lg mt-1 mb-2" pattern="[A-Z-0-9]{25,26}" title="Invalid IBAN number" minlength="25" maxlength="26" placeholder="<?=(isset($user_account->iban)) ? $user_account->iban : ""?>">
                            </div>
                            <div class="col-sm-1 font-weight-bold">
                                <label>Balance: </label>
                            </div>
                            <div class="col-sm-2">
                                <p>
                                    <span id="balance">
                                        <?php 
                                            $value = ($user_account->currency != 'EUR') ?number_format($user_account->balance*$currencies[$user_account->currency], 2, ".",",") : number_format($user_account->balance, 2, ".",",");
                                            echo $value;
                                        ?>
                                    </span>
                                    <span>
                                        <?php echo (!$user_account->currency) ? "€" : CURRENCYSYMBOL[$user_account->currency];?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mr-auto ">
                        <div class="col-sm-1">
                            <label>Credit Card:</label>
                        </div>
                        <div class="col-sm-4">
                            <input class="col-sm-12 input-lg mt-1 mb-2" type="text" name="ccard" pattern="[0-9]{16}" title="Invalid Credit Card number" placeholder="<?=(!empty($user_account->ccard)) ? "XXXXXXXX".str_split($user_account->ccard, 8)[1] : ""?>">
                        </div>
                        <div class="col-sm-1">
                            <label>CSC: </label>
                        </div>
                        <div class="col-sm-1">  
                            <input class="col-sm-12 input-lg mt-1 mb-2" type="text" name="csc" pattern="[0-9]{3}">
                        </div>
                        <div class="col-sm-1">
                            <label>Expires</label>
                        </div>
                        <div class="col-sm-1">
                           <select name="expiresM" class="mt-1 mb-2">
                                <option value="0" selected disabled></option>
                                <?php for($i = 1; $i < 13; $i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php }?>
                           </select>
                        </div>
                        <div class="col-sm-1">
                           <select name="expiresY" class="mt-1 mb-2">
                                <option value="0" selected disabled></option>
                                <?php for($i = 20; $i < 28; $i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php }?>
                           </select>
                        </div>
                        <div class="col-sm-1">
                            <label>Currency:</label>
                        </div>
                        <div class="col-sm-1">
                            <select name="currency">
                                <option <?php if($user_account->currency == "EUR") echo "selected";?> value="<?=$base?>"><?=$base?></option>
                                <?php foreach($currencies as $currency=>$value){ ?>
                                <option <?php if($user_account->currency == $currency) echo "selected";?> value="<?=$currency?>"><?=$currency?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            <div class="text-center">
                <button type="submit" name="update" class="mr-5">Save</button>
                <button type="reset" name="reset" class="mr-5">Clear</button>
                <button type="submit" name="delete" value="iban" class="mr-5">Remove IBAN</button>
                <button type="submit" name="delete" value="ccard" class="mr-5">Remove CCard</button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-sm shadow p-3 mb-5 bg-white rounded text-dark text-left">
        <div class="row">
            <div class="col-sm">
                <p class="h4 text-center">Add Funds <i class="fas fa-info-circle" title="Selected currency is used when adding funds."></i></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="typeBank" value="<?=($user_account->iban) ? $user_account->iban : "";?>">
                            <input type="hidden" value="<?=$user_account->currency?>" name="currencyUsed">
                            <input type="hidden" value="<?=($user_account->currency == 'EUR') ? 1 : $currencies[$user_account->currency]?>" name="currencyValue">
                            <div class="col-sm"><p class="font-weight-bold">Bank Transfer</p></div>
                            <div class="col-sm"><p>Value:</p></div>
                            <div class="col-sm"><input type="text" name="value" class="col-lg input-lg mt-1 mb-2" min="1" max="50000" pattern="[0-9]{1,5}" title="Minimun 1 and Maximum 50000"></div>
                            <div class="col-sm"><button type="submit" name="addBank">Add by Bank</button></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm">
            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="typeCCard" value="<?=($user_account->ccard) ? $user_account->ccard : ""; ?>">
                            <input type="hidden" value="<?=$user_account->currency?>" name="currencyUsed">
                            <input type="hidden" value="<?=($user_account->currency == 'EUR') ? 1 : $currencies[$user_account->currency]?>" name="currencyValue">
                            <div class="col-sm"><p class="font-weight-bold">Credit Card</p></div>
                            <div class="col-sm"><p>Value:</p></div>
                            <div class="col-sm"><input type="text" name="value" class="col-lg input-lg mt-1 mb-2" min="1" max="50000" pattern="[0-9-.]{1,5}" title="Minimun 1 and Maximum 50000"></div>
                            <div class="col-sm"><button type="submit" name="addCC">Add by CCard</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm shadow p-3 mb-5 bg-white rounded text-dark">
    <p class="h4 text-center">Withdraw funds <i class="fas fa-info-circle" title="Selected currency is used when withdrawing cash."></i></p>
        <input type="text" id="withdrawAmount" name="value" min="1" max="<?=$user_account->balance?>" pattern="[0-9-.]{1,10}" title="Please insert valid numbers">
        <button type="button" name="withdraw" id="withdrawBtn">Withdraw</button>
        </div>
    </div>
</div>