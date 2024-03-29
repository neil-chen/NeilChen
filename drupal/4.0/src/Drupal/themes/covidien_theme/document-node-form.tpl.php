<?php
/**
 * @file
 * Used to customize the hardware node form.
 */
?>
<style>
  .named-config-select-table-left-content, .named-config-select-table-right-content {
    max-height: 200px;
    overflow-y: auto;
  }

</style>
<?php
$deviceTypeRelation = get_device_type_relation_with_gateway_version();
$deviceTypeRelationStr = '';
foreach ($deviceTypeRelation as $key => $value) {
  $deviceTypeRelationStr .= $key . ',' . $value . '|';
}
if (arg(0) == 'node' && arg(1) == 'add') {
  ?>
  <div class="document-node-form-add">
    <fieldset>
      <table class="form-item-table-full add_new"><tbody>
          <tr>
            <td style="padding-left : 0px;">
              <div class="form-item">
                <h4><?php echo t('1. Select Device Type'); ?></h4>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $doc_device_type; ?></div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="padding-left : 0px;">
              <div class="form-item">
                <h4><?php echo t('2. Enter Information about the new Document'); ?></h4>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="label_left">
                <label><?php echo t('Document Title:'); ?></label>
              </div>
              <div class="form-item-div doc_title">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $doc_title; ?> </div>
              </div>
              <div class="doc_external"><?php echo $filed_doc_external; ?></div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="label_left">
                <label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Document Part #:'); ?></label>
              </div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $doc_part; ?></div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="label_left">
                <label><?php echo t('Document Version:'); ?></label>
              </div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $doc_version; ?></div>
              </div>
            </td>
          </tr>

          <tr>
            <td>
              <div class="label_left">
                <label><?php echo t('Document Type:'); ?></label>
              </div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $field_documnet_type; ?></div>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="label_left">
                <label><?php echo t('Document Status:'); ?></label>
              </div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $doc_status; ?></div>
              </div>
            </td>
          </tr>

          <tr>
            <td>							
              <div class="form-item-div">
                <div class="label_left">
                  <label><?php echo t('File Name: (Browse to select a file)'); ?></label>
                </div>
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div class="form-item-left" style="width : 90%;">
                  <?php echo $field_document_file; ?>
                </div>
              </div>	
              <div style="clear : both;"></div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="without_label_left">
                <label><?php echo t('Description:'); ?></label>
                <?php echo $field_document_description; ?>
              </div>
            </td>
          </tr>
          <tr>
            <td>
              <div class="label_left">
                <label><?php echo t('Select Document Language:'); ?></label>
              </div>
              <div class="form-item-div">
                <div class="form-item-left">
                  <span title="This field is required." class="form-required">*</span>
                </div>
                <div><?php echo $field_document_language; ?></div>
              </div>
            </td>
          </tr>
          <tr>
            <td style="padding-left : 0px;">
              <div class="form-item">
                <h4><?php echo t('3. Associate the new Document with related Hardware, Software, Firmware'); ?></h4>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <table class="form-item-table-full" id="relation-item-table">
                <tr>
                  <td style="padding: 0px; display: none;">
                    <div class="form-item-div">
                      <div><label>Please select associate type:</label></div>
                      <div class="form-item-left">
                        <?php //echo $doc_assoicate_type_selection; ?>
                      </div>											
                    </div>
                  </td>
                </tr>
                <tr id="doc_hw_list_header" style="display : none;">
                  <td style="padding : 0px;">
                    <div class="form-item-div">
                      <div><label><?php echo t('Filter by hardware type:'); ?></label></div>
                      <div class="form-item-left"><?php echo $hw_filter_type; ?></div>											
                      <div class="form-item-left" style="padding-left : 20px; width : 50px;"><?php echo $hw_filter_go; ?></div>
                    </div>
                  </td>
                </tr>
                <tr id="doc_hw_list_body">
                  <td valign="top" style="padding-left : 0px;">
                    <?php echo $doc_hw_list; ?>
                    <div id="doc_hw_list_wraper" style="display:none;">
                      <?php echo $hidden_doc_hw_list; ?>
                    </div>
                  </td>
                </tr>
                <tr id="doc_sw_list_header" style="display : none;">
                  <td style="padding : 0px;">
                    <div class="form-item-div">
                      <div><label><?php echo t('Filter by Language:'); ?></label></div> 
                      <div class="form-item-left"><?php echo $sw_filter_lang; ?></div>
                      <div class="form-item-left" style="padding-left : 20px; width : 50px;"><?php echo $sw_filter_go; ?></div>
                    </div>
                  </td>
                </tr>
                <tr id="doc_sw_list_body">
                  <td valign="top" style="padding-left : 0px;">
                    <?php echo $doc_sw_list; ?>
                    <div id="doc_sw_list_wraper" style="display:none;">
                      <?php echo $hidden_doc_sw_list; ?>
                    </div>
                  </td>
                </tr>
                <tr id="doc_fw_list_body">
                  <td valign="top" style="padding-left : 0px;">
                    <div id="doc_fw_list_wraper">
                      <?php echo $doc_fc_list; ?>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="right">
              <div style="clear : both;"></div>
              <div class="form-item-div">
                <div class="form-item-right" style="width : 200px;"><?php echo $form_submit; ?></div>
                <div class="form-item-right"><a id="secondary_submit" href="<?php echo url('covidien/admin/document'); ?>"><?php echo t('Cancel'); ?></a></div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <input type="hidden" id="device_type_relation" name="device_type_relation" value="<?php echo $deviceTypeRelationStr; ?>" />
      <div style="display:none">
        <?php print $form_render; ?>
      </div>
    </fieldset>
  </div>
<?php } else {
  ?>

  <table class="form-item-table-full edit_new" >
    <tr>
      <td colspan="2" style="padding-left : 0px;">
        <h4><?php echo t('The Document details can be edited or archived here.'); ?></h4>
      </td>
    </tr>
    <tr>
      <td width="20%">
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Document Title:'); ?></label>
      </td>
      <td style="padding-left : 0px;">	
        <div><?php echo $doc_title; ?></div>
      </td>
      <td style="padding-left : 0px;">	
        <div><?php echo $filed_doc_external; ?></div>
      </td>
    </tr>
    <tr>
      <td width="20%">
        <span title="This field is required." class="form-required">*</span><label title="<?php echo t("Enter '0' if there is no Part #"); ?>"><?php echo t('Document Part #:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">	
        <div><?php echo $doc_part; ?></div>
      </td>
    </tr>
    <tr>
      <td width="25%">
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Document Version:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">	
        <div><?php echo $doc_version; ?></div>
      </td>
    </tr>

    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Device Type:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">
        <div><?php echo $doc_device_type; ?></div>
      </td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Document Type:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">
        <div><?php echo $field_documnet_type; ?></div>
      </td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Document Status:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">
        <div><?php echo $doc_status; ?></div>
      </td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('File Name: (Browse to select a file)'); ?></label>
      </td>
      <td style="padding : 0px;" colspan="2">
        <?php echo $field_document_file; ?>	
      </td>					
    </tr>
    <tr>
      <td  style="padding-left : 43px">
        <label><?php echo t('Description:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">
        <?php echo $field_document_description; ?>
      </td>
    </tr>
    <tr>
      <td>
        <span title="This field is required." class="form-required">*</span><label><?php echo t('Language:'); ?></label>
      </td>
      <td style="padding-left : 0px;" colspan="2">
        <div><?php echo $field_document_language; ?></div>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <table class="form-item-table-full" id="relation-item-table">
          <tr style="display: none;">
            <td style="padding: 0px;">
              <div class="form-item-div">
                <div><label>Please select associate type:</label></div>
                <div class="form-item-left">
                  <?php //echo $doc_assoicate_type_selection; ?>
                </div>											
              </div>
            </td>
          </tr>
          <tr id="doc_hw_list_header" style="display : none;">
            <td style="padding : 0px;">
              <div class="form-item-div">
                <div><label><?php echo t('Filter by hardware type:'); ?></label></div>
                <div class="form-item-left"><?php echo $hw_filter_type; ?></div>											
                <div class="form-item-left" style="padding-left : 20px; width : 50px;"><?php echo $hw_filter_go; ?></div>
              </div>
            </td>
          </tr>
          <tr id="doc_hw_list_body">
            <td valign="top" style="padding-left : 0px;">
              <?php echo $doc_hw_list; ?>
              <div id="doc_hw_list_wraper" style="display: none;">
                <?php echo $hidden_doc_hw_list; ?>
              </div>
            </td>
          </tr>
          <tr id="doc_sw_list_header" style="display: none;">
            <td style="padding: 0px;">
              <div class="form-item-div">
                <div><label><?php echo t('Filter by Language:'); ?></label></div> 
                <div class="form-item-left"><?php echo $sw_filter_lang; ?></div>
                <div class="form-item-left" style="padding-left : 20px; width : 50px;"><?php echo $sw_filter_go; ?></div>
              </div>
            </td>
          </tr>
          <tr id="doc_sw_list_body">
            <td valign="top" style="padding-left : 0px;">
              <?php echo $doc_sw_list; ?>
              <div id="doc_sw_list_wraper" style="display:none;">
                <?php echo $hidden_doc_sw_list; ?>
              </div>
            </td>
          </tr>
          <tr id="doc_fw_list_body">
            <td valign="top" style="padding-left : 0px;">
              <div id="doc_fw_list_wraper">
                <?php echo $doc_fc_list; ?>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="3" style="padding-left : 0px;">
        <div class="form-item-div">
          <!-- not show delete button --> 
          <div class="form-item-left" style="width : 170px; padding-left : 18px; display: none;"><?php echo $form_delete; ?></div>
          <div class="form-item-right" style="width : 200px; padding-right : 10px;"><?php echo $form_submit; ?></div>
          <div class="form-item-right"><a id="secondary_submit" href="<?php echo url('covidien/admin/document') ?>"><?php echo t('Cancel'); ?></a></div>
        </div>
      </td>
    </tr>			
  </table>
  <input type="hidden" id="device_type_relation" name="device_type_relation" value="<?php echo $deviceTypeRelationStr; ?>" />
  <div style="display:none" >
    <?php print $form_render; ?>
  </div>

<?php } ?>
<input type="hidden" value="<?php echo $form['nid']['#value']; ?>" id="document_id"/>