<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  mounted() {
    let uri = "../getProductSalesPerDate?";
    let Dates = new Array();
    let ProductType = new Array();
    let LitresPumped = new Array();
    let Colors = new Array();
    let dataset = new Array();
    this.axios.get(uri).then(response => {
      let data = response.data;
      if (data) {
        data.forEach(datum => {
          datum.forEach(element => {
            Dates.push(element.sales_date);
            ProductType.push(element.product_type);
            LitresPumped.push(element.litres_pumped);
            Colors.push(element.color);
            //console.log(Dates);
            dataset.push({
              label: "Product Sales Per Date",
              backgroundColor: Colors,
              data: LitresPumped
            });
            console.log(dataset);
          });
        });
        this.renderChart(
          {
            labels: Dates,
            datasets: [
              {
                label: "Product Sales Per Date",
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