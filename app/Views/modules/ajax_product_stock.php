                                          <?php
                                            $qSum = $db->query("select sum(debit) as 'sum_in', sum(credit) as 'sum_out' from stocks where product_id='" . $product->id . "'");
                                            $rSum = $qSum->getFirstRow();
                                            $dSumIn = $rSum->sum_in;
                                            $dSumOut = $rSum->sum_out;
                                            ?>
                                          <?php
                                            $sumGoodStock = $dSumIn - $dSumOut;
                                            ?>
                                          <div class="form-group">
                                              <div id="tampilan_barang_keluar" style="display:block">
                                                  <label for="barang_keluar_req">Penyesuaian Stok</label>
                                                  <input type="number" class="form-control" id="barang_keluar_req" max="<?= $sumGoodStock; ?>" placeholder="max : <?= $sumGoodStock; ?>" name="credit" required placeholder="stok">
                                              </div>

                                              <div id="tampilan_barang_masuk" style="display:none">
                                                  <label for="barang_masuk_req">Penyesuaian Stok</label>
                                                  <input type="number" class="form-control" id="barang_masuk_req" min="1" placeholder="min : 1" name="debit" placeholder="stok">
                                              </div>
                                          </div>
                                          <div class="form-group">
                                              <label for="exampleFormControlTextarea1">Detail</label>
                                              <textarea class="form-control" name="details" id="exampleFormControlTextarea1" placeholder="detail" rows="3" required></textarea>
                                          </div>
                                          <div class="form-group">
                                              <label for="stock">Status</label>
                                              <br>
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" onclick="javascript:cek();" id="barang_keluar" name="status" value="credit" checked>
                                                  <label class="form-check-label" for="barang_keluar">Barang Keluar</label>
                                              </div>
                                              <div class="form-check form-check-inline">
                                                  <input class="form-check-input" type="radio" onclick="javascript:cek();" id="barang_masuk" name="status" value="debit">
                                                  <label class="form-check-label" for="barang_masuk">Barang Masuk</label>
                                              </div>
                                          </div>
                                          <div class="modal-footer" style="padding-top:20px;">
                                              <button type="submit" class="btn btn-danger">Terapkan</button>
                                          </div>

                                          <script type="text/javascript">
                                              function valueChanged() {
                                                  if ($('#barang_keluar').is(":checked"))
                                                      $("#tampilan_barang_masuk").hide()
                                                  else
                                                      $("#tampilan_barang_masuk").hide();
                                              }
                                          </script>

                                          <script type="text/javascript">
                                              function cek() {
                                                  if (document.getElementById('barang_masuk').checked) {
                                                      document.getElementById('tampilan_barang_masuk').style.display = 'block';
                                                      document.getElementById('barang_masuk_req').required = true;
                                                      document.getElementById('tampilan_barang_keluar').style.display = 'none';
                                                      document.getElementById('barang_keluar_req').required = false;
                                                  }
                                                  if (document.getElementById('barang_keluar').checked) {
                                                      document.getElementById('tampilan_barang_keluar').style.display = 'block';
                                                      document.getElementById('barang_keluar_req').required = true;
                                                      document.getElementById('tampilan_barang_masuk').style.display = 'none';
                                                      document.getElementById('barang_masuk_req').required = false;
                                                  }
                                              }
                                          </script>