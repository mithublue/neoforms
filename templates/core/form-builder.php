<template id="VueFormBuilder">
    <div class="cc-edit-panel">
        <el-row>
            <template class="form-group" v-for="(field, k) in native_schema" v-if="field.visible(model)">
                <el-col :sm="24" :class="field.wrapperclass">
                    <template v-if="field.type == 'input'">
                        <template v-if="field.inputType != 'checkbox' && field.inputType != 'radio'">
                            <label>{{ field.label }}</label>
                            <input :type="field.inputType" v-model="model[field.model]" class="el-input__inner"
                                   :maxlength="field.maxlength"
                                   :placeholder="field.placeholder"
                                   @click="field.click"
                                   @dblclick="field.dblclick"
                                   @change="field.change(model,parent_model)"
                            >
                            <p class="description" v-if="field.desc">{{ field.desc }}</p>
                        </template>
                        <template v-else>
                            <label>{{ field.label }}</label>
                            <template v-for="(opt_label, opt_value) in field.options">
                                <label>
                                    <input :type="field.inputType" v-model="model[field.model]" :value="opt_value"
                                           :maxlength="field.maxlength"
                                           :placeholder="field.placeholder"
                                           @click="field.click"
                                           @dblclick="field.dblclick"
                                           @change="field.change(model,parent_model)"
                                    > {{ opt_label }}
                                </label>
                                <p class="description" v-if="field.desc">{{ field.desc }}</p>
                            </template>
                        </template>
                    </template>
                    <template v-if="field.type == 'textarea'">
                        <label>{{ field.label }}</label>
                        <textarea class="el-input__inner" rows="10" v-model="model[field.model]"
                                  :maxlength="field.maxlength"
                                  :placeholder="field.placeholder"
                                  @click="field.click"
                                  @dblclick="field.dblclick"
                                  @change="field.change(model,parent_model)"
                        ></textarea>
                        <p class="description" v-if="field.desc">{{ field.desc }}</p>
                    </template>
                    <template v-if="field.type == 'select'">
                        <div>
                            <label>
                                {{ field.label }}
                            </label>
                        </div>
                        <select v-model="model[field.model]" :multiple="field.multiple" class="el-input__inner"
                                :maxlength="field.maxlength"
                                :placeholder="field.placeholder"
                                @click="field.click"
                                @dblclick="field.dblclick"
                                @change="field.change(model,parent_model)"
                        >
                            <option v-for="(opt_label, opt_value) in field.options" :value="opt_value">
                                {{ opt_label }}
                            </option>
                        </select>
                        <p class="description" v-if="field.desc">{{ field.desc }}</p>
                    </template>
                    <template v-if="field.type == 'upload'">
                        <div>
                            <label>
                                {{ field.label }}
                            </label>
                        </div>
                        <div>
                            <img :src="model[field.model]" alt="image" v-if="model[field.model]" width="100">
                        </div>
                        <input class="upload_image form-control mb5" type="text" size="36" v-model="model[field.model]" />
                        <input class="upload_image_button btn btn-default" type="button" value="<?php echo  'Upload';?>" @click="field.click(model)" />
                        <input class="upload_image_button btn btn-default" type="button" value="<?php echo 'Remove' ;?>" v-if="field.model" @click="field.model=''; return false; " />
                        <p class="description" v-if="field.desc">{{ field.desc }}</p>
                    </template>
                    <template v-if="field.type == 'repeatable'">
                        <label>{{ field.label }}</label>
                        <p class="description mb20" v-if="field.desc">{{ field.desc }}</p>
                        <el-collapse accordion>
                            <template v-for="(group, k) in model[field.model]">
                                <el-collapse-item title="Option" :name="k">
                                    <div class="panel panel-default mb5 panel-repeatable">
                                        <div class="panel-heading card-header oh">
                                            <!--                                    <h5 class="pull-left" data-toggle="collapse" :data-target="'#collapse' + field.model + k"><a href="javascript:">Item</a></h5>-->
                                            <a @click="removeItem(model[field.model],k)" href="javascript:" class="neoforms_btn-flat pull-right btn-danger btn-default btn-sm btn-outline"><i class="el-icon el-icon-remove-outline"></i></a>
                                            <a href="javascript:" @click="moveItemUp(model[field.model],k)" class="neoforms_btn-flat pull-right btn-light btn-default btn-sm btn-outline"><i class="el-icon el-icon-arrow-up"></i></a>
                                            <a href="javascript:" @click="moveItemDown(model[field.model],k)" class="neoforms_btn-flat pull-right btn-light btn-default btn-sm btn-outline"><i class="el-icon el-icon-arrow-down"></i></a>
                                        </div>
                                        <div class="panel-body card-body collapse" :id="'collapse' + field.model + k">
                                            <vue_form_builder :model="group" :schema="field.group" :parent_model="model"></vue_form_builder>
                                        </div>
                                    </div>
                                </el-collapse-item>
                            </template>
                        </el-collapse>
                        <a @click="addItem(model[field.model],field.group)" href="javascript:" class="btn btn-success neoforms_btn-flat">{{ field.add_button_label }}</a>
                    </template>
                    <template v-if="field.type == 'datetimepicker'">
                        <label>{{ field.label }}</label>
                        <div>
                            <el-date-picker
                                    v-model="model[field.model]"
                                    type="datetime"
                                    placeholder="Select date and time">
                            </el-date-picker>
                        </div>
                    </template>
                </el-col>
            </template>
        </el-row>
    </div>
</template>