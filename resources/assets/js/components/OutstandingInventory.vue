<script>
import { Bar } from "vue-chartjs";

export default {
  extends: Bar,
  mounted() {
    let uri = "../getOutstandingInventory?";
    let ProductType = new Array();
    let UnitPrice = new Array();
    let Colors = new Array();
    this.axios.get(uri).then(response => {
      let data = response.data;
      if (data) {
        data.forEach(element => {
          ProductType.push(element.product_type);
          UnitPrice.push(element.litres_pumped);
          Colors.push(element.color);
        });
        this.renderChart(
          {
            labels: ProductType,
            UnitPrice,
            datasets: [
              {
                label: "Outstanding Inventory",
                backgroundColor: Colors,
                data: UnitPrice
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