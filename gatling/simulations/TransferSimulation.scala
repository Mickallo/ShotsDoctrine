package simulations

import io.gatling.core.Predef._
import io.gatling.http.Predef._
import scala.concurrent.duration._

class TransferSimulation extends Simulation {

  val httpProtocol = http
    .baseUrl("http://nginx:80")
    .inferHtmlResources()

  val scn = scenario("Transfer Scenario")
    .exec(
      http("Transfer Request")
        .get("/transfer/without_lock/1/2/1")
        //.get("/transfer/pessimistic_wait/1/2/1")
        //.get("/transfer/pessimistic_error/1/2/1")
        //.get("/transfer/optimistic/1/2/1")
        .check(status.in(200,500))
    )

  setUp(
    scn.inject(
      rampUsers(100) during (1 seconds) // 100 utilisateurs en 1 secondes
    ).protocols(httpProtocol)
  )
}
