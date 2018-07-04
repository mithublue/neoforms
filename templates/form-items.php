<!--text-->
<template v-if="field_data.preview.name == 'text'">
    <el-input
            v-model="field_data.s.value"
            :name="field_data.s.name"
            :placeholder="field_data.s.placeholder"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :maxlength="field_data.s.maxlength"
    ></el-input>
</template>

<!--textarea-->
<el-input
    v-if="field_data.preview.name == 'textarea'"

    :placeholder="field_data.s.placeholder"
    :maxlength="field_data.s.maxlength"
    v-model="field_data.s.value"

    type="textarea"
    :autosize="{ minRows: 5}"

    :name="field_data.s.name"
    :id="field_data.s.id"
    :class="field_data.s.class"
>
</el-input>
<!--number-->
<template v-if="field_data.s.min && !field_data.s.max">
    <el-input-number
            v-if="field_data.preview.name == 'number'"
            v-model="field_data.s.value"

            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :min="field_data.s.min"
            :step="field_data.s.step"
            :size="field_data.s.size"
            :controls="field_data.s.controls"


    >
    </el-input-number>
</template>
<template v-if="!field_data.s.min && field_data.s.max">
    <el-input-number
            v-if="field_data.preview.name == 'number'"
            v-model="field_data.s.value"

            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :max="field_data.s.max"
            :step="field_data.s.step"
            :size="field_data.s.size"
            :controls="field_data.s.controls"
    >
    </el-input-number>
</template>
<template v-if="field_data.s.min && field_data.s.max">
    <el-input-number
            v-if="field_data.preview.name == 'number'"
            v-model="field_data.s.value"

            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :min="field_data.s.min"
            :max="field_data.s.max"
            :step="field_data.s.step"
            :size="field_data.s.size"
            :controls="field_data.s.controls"
    >
    </el-input-number>
</template>
<template v-if="!field_data.s.min && !field_data.s.max">
    <el-input-number
            v-if="field_data.preview.name == 'number'"
            v-model="field_data.s.value"

            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :step="field_data.s.step"
            :size="field_data.s.size"
            :controls="field_data.s.controls"
    >
    </el-input-number>
</template>
<!--radio-->
<template v-if="field_data.preview.name == 'radio'">
    <template v-if="field_data.s.border">
        <el-radio

                v-model="field_data.s.selected_val"
            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            border
            :size="field_data.s.size"
            :label="field_data.s.value"

        > {{ field_data.s.option_label }}
        </el-radio>
    </template>
    <template v-else>
        <el-radio
                v-model="field_data.s.selected_val"
            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :size="field_data.s.size"
            :label="field_data.s.value"

        > {{ field_data.s.option_label }}
        </el-radio>
    </template>
</template>
<!--radio_group-->
<template v-if="field_data.preview.name == 'radio_group'">
    <el-radio-group
            v-model="field_data.s.selected_val"
        :id="field_data.s.id"
        :class="field_data.s.class"
    >
        <template v-if="field_data.s.border">
            <template v-for="(option, k) in field_data.s.options">
                <el-radio
                        border
                        :size="field_data.s.size"
                        :name="field_data.s.name"

                        :label="option.value"
                >{{ option.option_label }}</el-radio>
            </template>
        </template>
        <template v-else>
            <template v-for="(option, k) in field_data.s.options">
                <el-radio
                        :size="field_data.s.size"
                        :name="field_data.s.name"

                        :label="option.value"
                >{{ option.option_label }}</el-radio>
            </template>
        </template>
    </el-radio-group>
</template>
<!--checkbox-->
<template v-if="field_data.preview.name == 'checkbox'">
    <template v-if="field_data.s.border">
        <div>
            {{ field_data.s.selected_value }}
            <el-checkbox
                    v-model="field_data.s.selected_val"
                    :name="field_data.s.name"
                    :id="field_data.s.id"
                    :class="field_data.s.class"

                    border
                    :size="field_data.s.size"
                    :label="field_data.s.value"
            > {{ field_data.s.option_label }}
            </el-checkbox>
        </div>
    </template>
    <template v-else>
        <el-checkbox
                v-model="field_data.s.selected_val"
            :name="field_data.s.name"
            :id="field_data.s.id"
            :class="field_data.s.class"

            :size="field_data.s.size"
            :label="field_data.s.value"
        > {{ field_data.s.option_label }}

        </el-checkbox>
    </template>
</template>
<!--checkbox group-->
<template v-if="field_data.preview.name == 'checkbox_group'">
    <template v-if="field_data.s.maxnum">
        <el-checkbox-group
                v-model="field_data.s.sel_values"
                :id="field_data.s.id"
                :class="field_data.s.class"
                :max="field_data.s.maxnum"
        >
            <template v-if="field_data.s.border">
                <template v-for="(option,k) in field_data.s.options">
                    <el-checkbox
                            :name="field_data.s.name"
                            :label="option.value"
                            :size="field_data.s.size"
                            border
                    >{{option.label}}</el-checkbox>
                </template>
            </template>
            <template v-else>
                <template v-for="(option,k) in field_data.s.options">
                    <el-checkbox
                            :name="field_data.s.name"
                            :label="option.value"
                            :size="field_data.s.size"
                    >{{option.label}}</el-checkbox>
                </template>
            </template>

        </el-checkbox-group>
    </template>
    <template v-if="!field_data.s.maxnum">
        <el-checkbox-group
                v-model="field_data.s.sel_values"
                :id="field_data.s.id"
                :class="field_data.s.class"
        >
            <template v-if="field_data.s.border">
                <template v-for="(option,k) in field_data.s.options">
                    <el-checkbox
                            :name="field_data.s.name"
                            :label="option.value"
                            :size="field_data.s.size"
                            border
                    >{{option.label}}</el-checkbox>
                </template>
            </template>
            <template v-else>
                <template v-for="(option,k) in field_data.s.options">
                    <el-checkbox
                            :name="field_data.s.name"
                            :label="option.value"
                            :size="field_data.s.size"
                    >{{option.label}}</el-checkbox>
                </template>
            </template>
        </el-checkbox-group>
    </template>
</template>
<!--select-->
<template v-if="field_data.preview.name == 'select'">
    <el-select v-model="field_data.s.selected_val"
               :name="field_data.s.name"
               :id="field_data.s.id"
               :class="field_data.s.class"
               :size="field_data.s.size"
               :placeholder="field_data.s.placeholder"
    >
        <template v-for="(item,k) in field_data.s.options">
            <el-option
                    :label="item.label"
                    :value="item.value">
            </el-option>
        </template>
    </el-select>
</template>
<!--website_url-->
<el-input
    v-if="field_data.preview.name == 'website_url'"
    :name="field_data.s.name"
    :id="field_data.s.id"
    :class="field_data.s.class"
    :v-model="field_data.s.value"

    :placeholder="field_data.s.placeholder"
    :maxlength="field_data.s.maxlength"
></el-input>
<!--email_address-->
<el-input
    v-if="field_data.preview.name == 'email_address'"
    :v-model="field_data.s.value"
    :name="field_data.s.name"
    :placeholder="field_data.s.placeholder"
    :id="field_data.s.id"
    :class="field_data.s.class"
    :maxlength="field_data.s.maxlength"
></el-input>
<!--hidden field-->
<template v-if="field_data.preview.name == 'hidden_field'">
    <input type="hidden"
           :v-model="field_data.s.value"
           :name="field_data.s.name"
           :id="field_data.s.id"
           :class="field_data.s.class"
    >
</template>
<template v-if="field_data.preview.name == 'password'">
    <el-input type="password" v-model="field_data.s.value"
              :name="field_data.s.name"
              :id="field_data.s.id"
              :class="field_data.s.class"
              :maxlength="field_data.s.maxlength"
              :minlength="field_data.s.minlength"
              auto-complete="off"></el-input>

    <template v-if="field_data.s.retype_password">
        <el-input type="password"
                  :name="field_data.s.name + '_retype'"
                  placeholder="<?php _e( 'Retype Password', 'neoforms' ); ?>"
                  auto-complete="off"></el-input>
    </template>
</template>