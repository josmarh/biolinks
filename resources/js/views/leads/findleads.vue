<template>
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="text-center" style="margin-bottom: 2rem">
      <h1 class="h3 mb-0 text-gray-800">Find Prospects</h1>
    </div>
    <div v-show="showForm" ref="formsearch">
      <div class="col-md-5 col-sm-8 mx-auto my-auto searchBox">
        <div class="text-center">
          <div class="row form-group">
            <div class="col-6">
              <input
                v-model="search.q"
                class="form-control"
                placeholder="Enter your keyword/Niche"
                type="text"
                
              />
            </div>
            <div class="col-6">
              <input
                id="autocomplete"
                ref="autocomplete"
                class="form-control"
                placeholder="Enter the location (City)"
                type="text"
                v-model="search.name"
              />
            </div>
          </div>
          <button
            class="btn btn-primary"
            type="submit"
            @click.prevent="doSearch"
            :disabled="loading"
          >
            <span v-html="searchBoxTxt"></span>
            <div
              :hidden="!sSpinner"
              class="spinner-grow text-light spinner-grow-sm"
              role="status"
              style="top: -3px; position: relative"
            >
              <span class="sr-only">Loading...</span>
            </div>
          </button>
          <button
            class="btn resetSearch"
            data-toggle="popover"
            title="Reset Search"
            type="submit"
            @click="resetSearch"
          >
            <span class="x">[x]</span>&nbsp;<span class="txt"
              >close & new search</span
            >
          </button>
        </div>
      </div>
      <div v-show="showBusinnessTable" :class="animate" class="animHold">
        <table ref="prospectsTable" class="table table-striped">
          <thead class="thead-light">
            <tr>
              <th scope="col">Business name</th>
              <th scope="col">Website url</th>
              <th scope="col">Country/City</th>
              <th scope="col">Phone/Email</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(prospect, index) in prospects" :key="index">
              <td>{{ prospect.name }}</td>
              <td>
                <a :href="prospect.url" target="_blank">{{
                  prospect.url || shortDomain
                }}</a>
              </td>
              <td>
                {{ prospect.country || "-" }}<br v-if="prospect.country" />{{
                  prospect.city || "-"
                }}
              </td>
              <td>
                {{ prospect.phone || "-" }}<br v-if="prospect.phone" />{{
                  prospect.email || "-"
                }}
              </td>
              <td class="td_actions">
                <button
                  v-show="!prospect.prospect"
                  class="btn less-padding btn-sm btn-action"
                  title="Add to your prospects"
                  type="button"
                  @click="addAsProspect(prospect, index)"
                >
                  <i class="fas fa-plus"></i>
                </button>
                <router-link
                  v-show="prospect.prospect"
                  class="already_added btn less-padding btn-sm"
                  data-toggle="tooltip"
                  title="Already added"
                  to="/myleads"
                  type="button"
                >
                  <i class="fas fa-check"></i>
                </router-link>
                <button
                  class="btn less-padding btn-sm btn-action"
                  data-toggle="tooltip"
                  title="Details"
                  type="button"
                  @click="openDetails(prospect, index)"
                >
                  <i class="fas fa-eye"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <p class="text-center">
          <button v-if="loadMore" class="btn btn-primary" @click="doLoadMore">
            {{ !sSpinner ? "Load More" : "Searching prospects, please wait" }}
            <span
              class="spinner-grow text-light spinner-grow-sm"
              role="status"
              style="top: -3px; position: relative"
            >
            </span>
          </button>
        </p>
      </div>
    </div>
    <div v-show="!showForm" :class="showForm" ref="toprofile">
      <div class="empty text-center text-gray-500 pt-5 body">
        <img
          alt=""
          class="max-w-xs"
          src="data:image/svg+xml,%3Csvg enable-background='new 0 0 36 36' height='512' viewBox='0 0 36 36' width='512' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='m1.003 14.311c3.253 6.104 2.324 11.981 3.891 14.923s6.551 8.218 20.083 1.008 11.09-16.579 9.365-19.815c-8.072-15.151-39.1-6.927-33.339 3.884z' fill='%23efefef'/%3E%3Ccircle cx='12.5' cy='12.5' fill='%23806FF6' r='5.75'/%3E%3Cpath d='m9 12.5c0-2.79 1.988-5.115 4.625-5.638-.364-.073-.74-.112-1.125-.112-3.176 0-5.75 2.574-5.75 5.75s2.574 5.75 5.75 5.75c.385 0 .761-.039 1.125-.112-2.637-.523-4.625-2.848-4.625-5.638z' fill='%23bd92f4'/%3E%3Cg fill='%23a4afc1'%3E%3Cpath d='m26.496 3.907h1v2h-1z' transform='matrix(.707 -.707 .707 .707 4.431 20.519)'/%3E%3Cpath d='m30.562 7.974h1v2h-1z' transform='matrix(.707 -.707 .707 .707 2.753 24.593)'/%3E%3Cpath d='m25.819 8.474h2v1h-2z' transform='matrix(.707 -.707 .707 .707 1.51 21.593)'/%3E%3Cpath d='m29.885 4.408h2v1h-2z' transform='matrix(.707 -.707 .707 .707 5.576 23.277)'/%3E%3C/g%3E%3Cpath d='m12.5 19c-3.584 0-6.5-2.916-6.5-6.5s2.916-6.5 6.5-6.5 6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5zm0-11.5c-2.757 0-5 2.243-5 5s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z'/%3E%3Cpath d='m23.28 29.78-1.06-1.06 1.836-1.836c.487-.487.487-1.28 0-1.768l-7.843-7.844 1.061-1.061 7.843 7.844c1.072 1.072 1.072 2.816 0 3.889z'/%3E%3Cpath d='m18.077 22.875h4.596v1.5h-4.596z' transform='matrix(.707 -.707 .707 .707 -10.738 21.327)'/%3E%3C/svg%3E"
        />
        <h3>Google API</h3>
        <router-link to="/profile">
          <b style="text-decoration: underline">please set your API key. </b>
        </router-link>
      </div>
    </div>
    <!-- Start Modal -->
    <div class="centerx con-exemple-prompt">
      <!--  -->
      <vs-prompt
        :active.sync="activePrompt"
        :title="prospectDetailTitle"
        accept-text="Add to prospect"
        color="#008eff"
        @accept="addProspectFromDetails"
        @cancel="val = ''"
        button-cancel="border"
        @close="close"
      >
        <ul class="list-group list-group-flush">
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Url</b></div>
              <div class="col-8">
                <a
                  :href="this.currentProspect.url"
                  style="color: #262c49; text-decoration: underline;word-break: break-all;"
                  >{{ this.currentProspect.url }}</a
                >
              </div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Phone</b></div>
              <div class="col-8">{{ this.currentProspect.phone }}</div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Adress</b></div>
              <div class="col-8">{{ this.currentProspect.addresse }}</div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Categories</b></div>
              <div class="col-8">
                <span
                  class="badge badge-primary mr-1 ng-star-inserted"
                  v-for="(categorie, index) in splitCategories(
                    this.currentProspect.types
                  )"
                  :key="index"
                  >{{ categorie }}</span
                >
              </div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Rating</b></div>
              <div class="col-8">
                (<b>{{ this.currentProspect.ratings }}</b
                >)&nbsp;
              </div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>Country</b></div>
              <div class="col-8">{{ this.currentProspect.country }}</div>
            </div>
          </li>
          <li class="list-group-item ng-star-inserted">
            <div class="row">
              <div class="col-4"><b>City</b></div>
              <div class="col-8">{{ this.currentProspect.city }}</div>
            </div>
          </li>
        </ul>
      </vs-prompt>
    </div>
  </div>
</template>

<script>
//import * as VueGoogleMaps from "vue2-google-maps" // Import package

export default {
  data() {
    return {
      dtOptions: {},
      animate: false,
      sSpinner: false,
      searchBoxTxt: "Search Prospects",
      search: {
        q: "plumber",
        latitude: "",
        longitude: "",
        raduis: "20000",
        name: "Miami",
      },
      prospects: {},
      loadMore: true,
      //dtElement: DataTableDirective,
      //dtTrigger: Subject<any> = new Subject(),
      loadMoreToken: "",
      showDetailsModal: false,
      currentProspect: {},
      currentProspectIndex: 0,
      showForm: false,
      autocomplete: null,
      showBusinnessTable: false,
      select1: 2,
      options1: [
        { text: "IT", value: 0 },
        { text: "Blade Runner", value: 2 },
        { text: "Thor Ragnarok", value: 3 },
      ],
      activePrompt: false,
      val: "Information for ",
      valMultipe: {
        value1: "",
        value2: "",
      },
      loading: false,
    };
  },
  computed: {
    validName() {
      return (
        this.valMultipe.value1.length > 0 && this.valMultipe.value2.length > 0
      );
    },
    prospectDetailTitle() {
      return `Details for ${this.currentProspect.name}`;
    },
    currentProspectTypes(str) {
      return str.toString().split(",");
    },
  },
  mounted() {
    this.$nextTick(() => {
      let self = this;
      this.autocomplete = self.$refs.autocomplete;
      window.gm_authFailure = function () {
        console.log("fail");
        console.log(self.$refs);
        self.$refs.formsearch.style.display = "none";
        self.$refs.toprofile.style.display = "block";
        this.showForm = false;
        return;
      };
    });
  },
  created() {
    this.initGoogleApi();
  },
  methods: {
    async initGoogleApi() {
      try {
        const resp = await this.$store.dispatch("fetchUser", {
          role: this.$route.role,
        });
        this.showForm = resp.user.api_key !== "";
        this.$loadScript(
          `https://maps.googleapis.com/maps/api/js?v=3&key=${resp.user.api_key}&libraries=places`
        )
          .then(() => {
            console.log("ok");
            this.getPlaceAutocomplete();
            // this.showForm = true;
          })
          .catch((e) => {
            console.error(e);
            this.showForm = false;
          });
      } catch (e) {
        console.error(e);
        this.showForm = false;
      }
    },
    async doSearch(e) {
      e.preventDefault();
      this.loading = true;
      this.$vs.loading();
      if (this.prospects && this.animate === true) return;
      if (this.search.q === "") {
        this.$vs.notify({
          color: "danger",
          title: "Error",
          text: "Please you must search by keyword !",
        });
      }
      if (this.search.latitude === "" || this.search.longitude === "") {
        this.$vs.notify({
          color: "danger",
          title: "Error",
          text: "Please you must select a place !",
        });
      }
      this.sSpinner = !this.animate;
      try {
        const { data } = await this.$http.post(
          "/api/prospects/search",
          this.search
        );
        if (data.status === 1) {
          this.showBusinnessTable = true;
          if (this.prospects) {
            this.prospects = data.data.results;
          } else {
            this.prospects = data.data.results;
            //this.dtTrigger.next();
          }
          this.animate = true;
          this.searchBoxTxt = "<b>" + this.prospects.length + "</b> results";
          if (data.data.next_page_token && data.data.next_page_token !== "") {
            this.loadMore = true;
            this.loadMoreToken = data.data.next_page_token;
          }
          this.$vs.loading.close();
          this.loading = false;
        }
        if (data.status === -1) {
          this.$vs.notify({
            color: "danger",
            title: "Error",
            text: "Please check !",
          });
          this.$vs.loading.close();
          this.loading = false;
        }
        this.sSpinner = false;
      } catch (e) {
        console.error(e);
        this.loading = false;
        this.$vs.notify({
          color: "danger",
          title: "Error",
          text: `Please check ${e.message}!`,
        });
        this.$vs.loading.close();
      }
    },
    doLoadMore() {
      this.sSpinner = true;
      let _token = this.loadMoreToken;
      this.loadMoreToken = "";
      this.pS.searchMore({ token: _token }).subscribe(
        (data) => {
          if (data.status === 1) {
            data.data.results.forEach((element) => {
              this.prospects.push(element);
            });
            this.searchBoxTxt = "<b>" + this.prospects.length + "</b> results";
            if (data.data.next_page_token && data.data.next_page_token !== "") {
              this.loadMore = true;
              this.loadMoreToken = data.data.next_page_token;
            } else {
              this.loadMore = false;
              this.loadMoreToken = "";
            }
          }
          if (data.status === -1) {
            this.toastr.info(data.message);
            this.loadMore = false;
            this.loadMoreToken = "";
          }
          this.sSpinner = false;
        },
        (error) => {
          this.sSpinner = false;
        }
      );
    },
    resetSearch() {
      //this.animate = false;
      //this.searchBoxTxt = "Search Prospects";
      //this.prospects = new Array();
      this.search.q = "";
      this.search.name = "";
      this.loading = false;
      this.searchBoxTxt = "Search Prospects";
      this.showBusinnessTable = false;
      this.$vs.notify({
        color: "success",
        title: "Success",
        text: "You have been remove Keyword and Location!!!!",
      });
      //this.rerender();
    },
    async addAsProspect(pre, index) {
      let _v = pre;
      _v.id = 0;
      _v.client = 0;
      try {
        const { data } = await this.$http.post("/api/prospects", _v);
        if (data.status === 1) {
          this.showDetailsModal = false;
          pre.status = 1;
          this.currentProspect = data.data;
          this.currentProspectIndex = index;
          this.prospects[index].prospect = data.data;
          this.$vs.notify({
            color: "success",
            title: "Success",
            text: "You have been add to my leads",
          });
        }
      } catch (e) {
        console.error(e);
        this.$vs.notify({
          color: "danger",
          title: "Error",
          text: "Please check again!",
        });
        this.$vs.loading.close();
      }
    },
    /**
     * Open function details Prospect(see) icon
     * @param prospect
     * @param index
     */
    openDetails(prospect, index) {
      /**
       * Show Model
       * @type {boolean}
       */
      this.activePrompt = true;
      /**
       * get Prospect and index for Adding and change icon to green
       */
      this.currentProspect = prospect;
      this.currentProspectIndex = index;
    },
    /**
     * Add Prospect Logic
     */
    async addProspectFromDetails() {
      /**
       * pre and index like addAsProscpect arguments
       * @type Object
       */
      const pre = this.currentProspect;
      const index = this.currentProspectIndex;

      let _v = pre;
      _v.id = 0;
      _v.client = 0;
      try {
        const { data } = await this.$http.post("/api/prospect", _v);
        if (data.status === 1) {
          //this.toastr.success('Prospect added');
          pre.status = 1;
          this.prospects[index].prospect = data.data;
          this.$vs.notify({
            color: "success",
            title: "Success",
            text: "You have been add to Proscpect",
          });
        }
      } catch (e) {
        console.error(e);
        this.sSpinner = false;
        // this.toastr.error(error)
        alert(e);
      }
    },
    ngAfterViewInit() {
      //this.getPlaceAutocomplete();
    },
    async getPlaceAutocomplete() {
      const autocomplete = new window.google.maps.places.Autocomplete(
        this.$refs.autocomplete,
        {
          types: ["geocode"],
        }
      );
      const place = window.google.maps.event.addListener(
        autocomplete,
        "place_changed",
        () => {
          const place = autocomplete.getPlace();
          this.search.latitude = place.geometry.location.lat();
          this.search.longitude = place.geometry.location.lng();
        }
      );
    },
    close() {
      this.$vs.notify({
        color: "danger",
        title: "Closed",
        text: "",
      });
    },
    splitCategories(str) {
      if (str !== undefined) return str.split(",");
      return str;
    },
  },
};
</script>

<style lang="scss" scoped>
.container-fluid {
  margin: 10px;
  margin-top: 5rem;
}

body {
  img {
    max-width: 150px;
  }
}

.td_actions {
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  a.already_added {
    color: green;
  }

  button {
    background: none;
  }
}

.con-exemple-prompt {
  padding: 10px;
  padding-bottom: 0px;

  .vs-input {
    width: 100%;
    margin-top: 10px;
  }
}

.current_prospect_details {
  color: #000;

  > div {
    &:first-child {
    }

    &:nth-child(2) {
      word-break: break-all;
    }
  }
}

.vs-dialog {
  max-width: 570px !important;
}
</style>
