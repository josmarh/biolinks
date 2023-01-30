<template>
  <div class="myleads">
    <vs-table
      :data="prospects"
      class="table_prospects"
      max-items="10"
      pagination
    >
      <template slot="header">
        <h3>All Prospects</h3>
      </template>
      <template slot="thead" style="color: red">
        <vs-th style="color: #0b1e2b !important"> Bussiness </vs-th>
        <vs-th style="color: #0b1e2b !important"> Website url </vs-th>
        <vs-th> Country </vs-th>
        <vs-th style="color: #0b1e2b !important"> Phone </vs-th>
        <vs-th style="color: #0b1e2b !important"> Email </vs-th>
        <vs-th style="color: #0b1e2b !important"> Categorie </vs-th>
        <vs-th style="color: #0b1e2b !important"> Actions </vs-th>
      </template>

      <template slot-scope="{ data }">
        <vs-tr v-for="(tr, indextr) in data" :key="indextr">
          <vs-td :data="data[indextr].name">
            {{ subString(data[indextr].name, 25, "..") }}
          </vs-td>

          <vs-td :data="data[indextr].url">
            {{ subString(data[indextr].url, 20, "...") }}
          </vs-td>

          <vs-td :data="data[indextr].country">
            {{ data[indextr].country }}
          </vs-td>

          <vs-td :data="data[indextr].phone">
            {{ data[indextr].phone }}
          </vs-td>

          <vs-td :data="data[indextr].email">
            {{ emailEmpty(data[indextr].email) }}
          </vs-td>

          <vs-td :data="data[indextr].types">
            <span style="word-break: break-all">{{ data[indextr].types }}</span>
          </vs-td>

          <vs-td class="prospect_buttons">
            <button
              class="prospect_actions"
              @click="showMailModal(data[indextr], indextr)"
            >
              <i class="fas fa-envelope-open"></i>
            </button>
            <button
              class="prospect_actions"
              @click="showEditModal(data[indextr], indextr)"
            >
              <i class="fas fa-pen"></i>
            </button>
            <button
              class="prospect_actions"
              @click="deleteProspectCheck(data[indextr].id, indextr)"
            >
              <i class="fas fa-trash-alt"></i>
            </button>
          </vs-td>
        </vs-tr>
      </template>
    </vs-table>
    <div class="centerx con-exemple-prompt">
      <!--
            -- Mail Modal
            -->
      <vs-prompt
        :active.sync="activeMailModal"
        accept-text="Send"
        color="#008eff"
        title="Send mail"
        @accept="sendMail"
        @cancel="cancelMailModal"
        @close="closeMailModal"
      >
        <form class="card-body p-3 w-500">
          <div class="form-group">
            <label for="message_email">Email</label>
            <input
              id="message_email"
              v-model="prospectMail.email"
              autocomplete="off"
              class="form-control"
              placeholder="Prospect Email"
              required="required"
              type="text"
            />
          </div>
          <div class="form-group row">
            <div class="col-md-6">
              <label for="message_subject">Subject</label>
              <input
                id="message_subject"
                v-model="prospectMail.subject"
                autocomplete="off"
                class="form-control"
                placeholder="Write your subject here"
                required="required"
                type="text"
              />
            </div>
            <div class="col-md-6">
              <label for="message_templates">Templates</label>
              <select
                v-show="templates.length !== 0"
                id="message_templates"
                v-model="prospectMail.templateId"
                class="custom-select form-control"
                @change="templateChanged"
              >
                <option
                  v-for="(template, index) in templates"
                  :value="template.id"
                >
                  {{ template.title }}
                </option>
              </select>
              <vs-button
                v-show="templates.length === 0"
                class="custom-control-inline"
                type="border"
                @click="addTemplate"
                >Add new Template
              </vs-button>
            </div>
          </div>
          <div class="form-group">
            <label for="msg_template">Message</label>
            <a class="pull-right font-size-14" href="javascript:void(0)">
              <i class="fa fa-copy"></i>
              Copy
            </a>
            <textarea
              id="msg_template"
              v-model="prospectMail.message"
              class="form-control"
              placeholder="Template will shows here"
              required="required"
              rows="5"
            ></textarea>
            <small class="form-text text-muted"
              >Change words between braces <code>{}</code></small
            >
          </div>
        </form>
      </vs-prompt>
      <vs-prompt
        :active.sync="activeEditModal"
        accept-text="Edit Prospect"
        color="#008eff"
        title="Edit Prospect"
        @accept="EditProspect"
        @cancel="cancelEditModal"
        @close="closeEditModal"
      >
        <form class="form_edit_prospect">
          <div class="row rr">
            <input class="form-control" type="hidden" value="128" />
            <div class="col-lg-4 col-sm-12">Business name</div>
            <div class="col-lg-8 col-sm-12">
              <input
                v-model="currentProspect.name"
                class="form-control"
                required="required"
                type="text"
              />
            </div>
          </div>
          <div class="row rr">
            <div class="col-lg-4 col-sm-12">Web site</div>
            <div class="col-lg-8 col-sm-12">
              <input
                v-model="currentProspect.url"
                class="form-control"
                required="required"
                type="text"
              />
            </div>
          </div>
          <div class="row rr">
            <div class="col-lg-4 col-sm-12">Email</div>
            <div class="col-lg-8 col-sm-12">
              <input
                v-model="currentProspect.email"
                class="form-control"
                required="required"
                type="text"
              />
            </div>
          </div>
          <div class="row rr">
            <div class="col-lg-4 col-sm-12">Country</div>
            <div class="col-lg-8 col-sm-12">
              <input
                v-model="currentProspect.country"
                class="form-control"
                required="required"
                type="text"
              />
            </div>
          </div>
          <div class="row rr">
            <div class="col-lg-4 col-sm-12">City</div>
            <div class="col-lg-8 col-sm-12">
              <input
                v-model="currentProspect.city"
                class="form-control"
                required="required"
                type="text"
              />
            </div>
          </div>
        </form>
      </vs-prompt>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      activeMailModal: false,
      activeEditModal: false,
      prospectMail: {
        email: "",
        subject: "",
        templateId: 0,
        message: "",
      },
      currentProspect: {},
    };
  },
  computed: {
    prospects() {
      return this.$store.getters.leadsProspects;
    },
    templates() {
      return this.$store.getters.templates;
    },
  },
  mounted() {
    this.loadProspects();
    this.loadMsgTemplates();
  },
  methods: {
    loadProspects() {
      this.$store.dispatch("getAllProspects");
    },
    loadMsgTemplates() {
      this.$store.dispatch("getMsgTemplates");
    },
    emailEmpty(email) {
      return email !== null ? email : "-";
    },
    async sendMail() {
      console.log("send mail");
      const mail = {
        email: this.prospectMail.email,
        subject: this.prospectMail.subject,
        content: this.prospectMail.message,
      };

      await this.$store.dispatch("sendMailToProspect", mail);
      this.$vs.notify({
        color: "success",
        title: "Well done!",
        text: "Email sent successfully",
      });
    },
    showMailModal(prospect, index) {
      this.activeMailModal = true;
      this.currentProspect = prospect;
    },
    showEditModal(prospect, index) {
      this.activeEditModal = true;
      this.currentProspect = prospect;
    },
    async deleteProspect(id, index) {
      console.log(index);
      const payload = {
        id,
        index,
      };
      console.log(payload);
      try {
        const data = await this.$store.dispatch("prospectDelete", payload);
        console.log(data);
        if (data.success) {
          this.$vs.notify({
            color: "success",
            title: "Edit with success",
            text: "You have been delete the prospect",
          });
        } else {
          this.$vs.notify({
            color: "danger",
            title: "Error",
            text: "Please check !",
          });
        }
      } catch (err) {
        console.log("hi");
        this.$vs.notify({
          color: "danger",
          title: "Closed",
          text: "Please check again!",
        });
      }
    },
    cancelMailModal() {
      this.$vs.notify({
        color: "danger",
        title: "Closed",
        text: "You close a dialog!",
      });
    },
    closeMailModal() {
      this.$vs.notify({
        color: "danger",
        title: "Closed",
        text: "You close a dialog!",
      });
    },
    addTemplate(e) {
      e.preventDefault();
      this.closeMailModal();
      this.activeMailModal = false;
      this.$router.push("profile");
    },
    templateChanged(e) {
      e.preventDefault();
      const template = this.templates.filter(
        (elem) => elem.id === this.prospectMail.templateId
      )[0];
      console.log(template);
      this.prospectMail.message = template.content;
    },
    async EditProspect() {
      try {
        const payload = {
          id: this.currentProspect.id,
          data: {
            name: this.currentProspect.name,
            url: this.currentProspect.url,
            email: this.currentProspect.email,
            country: this.currentProspect.country,
            city: this.currentProspect.city,
          },
        };
        const data = await this.$store.dispatch("prospectEdit", payload);
        if (data.success) {
          this.$vs.notify({
            color: "success",
            title: "Edit with success",
            text: "You have been edit the prospect",
          });
        } else {
          this.$vs.notify({
            color: "danger",
            title: "Error",
            text: "Please check !",
          });
        }
      } catch (e) {
        console.log("error editprosp");
        this.$vs.notify({
          color: "danger",
          title: "Closed",
          text: "Error!!",
        });
      }
    },
    cancelEditModal() {},
    closeEditModal() {},
    subString(str, number, points) {
      const finalString = str.substr(0, number) + " " + points;
      console.log(finalString);
      return finalString;
    },
  },
  watch: {
    templates(value) {
      console.log(value);
    },
  },
};
</script>
<style lang="scss">
.table_prospects {
  color: #000;
}

.myleads {
  margin-top: 2rem;
  h3 {
    margin-bottom: 30px;
    color: #0b1e2b;
  }
}

.prospect_buttons {
  > span {
    display: flex;
    button.prospect_actions {
      border: 0;
      padding: 6px;
      background: none;
      cursor: pointer;
      color: #0b1e2b;
    }
  }
}

.form_edit_prospect {
  > .row {
    padding: 5px;
  }
}
</style>
