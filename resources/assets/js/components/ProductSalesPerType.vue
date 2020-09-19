<script>
import { Pie } from "vue-chartjs";

export default {
  extends: Pie,
  mounted() {
    let uri = "../getProductSalesPerType?";
    let ProductType = new Array();
    let LitresPumped = new Array();
    let Colors = new Array();
    this.axios.get(uri).then(response => {
      let data = response.data;
      if (data) {
        data.forEach(element => {
          ProductType.push(element.product_type);
          LitresPumped.push(element.litres_pumped);
          Colors.push(element.color);
        });
        this.renderChart(
          {
            labels: ProductType,
            LitresPumped,
            datasets: [
              {
                label: "Product Sales Per Type",
                backgroundColor: Colors,
                data: LitresPumped
              }
            ]
          },
          { responsive: true, maintainAspectRatio: true }
        );
      } else {
        console.log("No data");
      }
    });
  }
};
</script>