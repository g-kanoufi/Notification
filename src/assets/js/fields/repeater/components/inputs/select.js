/* global Vue, jQuery, notification */
import { inputsHandler } from "../../mixins/inputsHandler";
import { fieldHandler } from "../../mixins/fieldHandler";

Vue.component("notification-select", {
	template: `<select
		:id="subfield.id"
		:name="createFieldName(type, keyIndex, subfield) + '[' + subfield.name + ']'"
		:class="subfield.css_class + ' ' + subfield.pretty + ' repeater-select'"
		@change="selectUpdate( subfield, field, $event )"
	>
		<template v-for="( option, key ) in subfield.options">
			<option :value="key" :selected="handleSelect( key, subfield.value )">{{option}}</option>
		</template>
	</select>
	`,
	props: ["field", "type", "keyIndex", "subfield"],
	mixins: [inputsHandler, fieldHandler],
	data() {
		return {
			selectized: null
		};
	},
	mounted() {
		this.initSelectize();
		notification.hooks.doAction(
			"notification.carrier.select.initialized",
			this
		);
	},
	beforeUpdate() {
		this.destroySelectize();
	},
	updated() {
		if (this.subfield.value) {
			this.$el.value = this.subfield.value;
		}

		this.initSelectize();
		notification.hooks.doAction("notification.carrier.select.changed", this);
	},
	beforeDestroy() {
		this.destroySelectize();
	},
	methods: {
		selectUpdate(subfield, field, $event) {
			if (field) {
				this.selectChange(subfield, field, $event);
			}
		},
		destroySelectize() {
			if (this.selectized) {
				const control = this.selectized[0].selectize;
				control.destroy();
			}
		},
		initSelectize() {
			if (this.$el.classList.contains("notification-pretty-select")) {
				this.selectized = jQuery(this.$el).selectize({
          valueField: 'user_email',
          labelField: 'user_email',
          searchField: 'user_email',
          create: false,
          render: {
            option: function(item, escape) {
              return '<div> <span class="user_email">' + escape(item.user_email) + '</span></div>';
            }
          },
          load: function(query, callback) {
            if (query.length < 3) {
              return callback();
            } else {
            jQuery.ajax({
              url: 'https://freshwp.local/wp-json/notification/v1/get-users?query=' + encodeURIComponent(query),
              type: 'GET',
              data: {
                limit: 3,
              },
              error: function () {
                callback();
              },
              success: function (res) {
                callback(res.data.slice(0, 10));
              }
            });
            }
          }
				});
			}
		}
	}
});
