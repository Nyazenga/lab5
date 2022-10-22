/*
RED_LED CONFIGURED
 Program for water level monitoring with LCD and Ultrasonic sensor
 */

#include <LiquidCrystal_I2C.h>
#include <WiFi.h>
#include <HTTPClient.h>


LiquidCrystal_I2C lcd(0x27, 16, 2);  // I2C address 0x27, 16 column and 2 rows

#define TRIG_PIN 5   // ESP32 pin GIOP5 connected to Ultrasonic Sensor's TRIG pin
#define ECHO_PIN 18  // ESP32 pin GIOP18 connected to Ultrasonic Sensor's ECHO pin
#define RED_LED 33
#define GREEN_LED 26
#define BUZZER 32
#define MOTOR 25


float duration, distance;
const int TANKID = 1
const int LOCATIONID = 1
const int OWNERID = 1
const char WIFI_SSID[] = "SIMBARASHE";
const char WIFI_PASSWORD[] = "01234567";

String HOST_NAME = "http://192.168.137.251";  // change to your PC's IP address
String PATH_NAME = "/Lab5/lab5/insert_waterlevel.php";
String queryString = "?TankID=1&LocationID=1&OwnerID=1&WaterLevel=2";


void setup() {
  Serial.begin(115200);
  
  lcd.init();                 // initialize the lcd
  lcd.backlight();            // open the backlight
  pinMode(TRIG_PIN, OUTPUT);  // config trigger pin to output mode
  pinMode(ECHO_PIN, INPUT);   // config echo pin to input mode
  pinMode(RED_LED, OUTPUT);  
   pinMode(GREEN_LED, OUTPUT); 
  pinMode(BUZZER, OUTPUT);
  pinMode(MOTOR, OUTPUT); 

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  HTTPClient http;

  http.begin(HOST_NAME + PATH_NAME);  //HTTP
  int httpCode = http.GET();

  // httpCode will be negative on error
  if (httpCode > 0) {
    // file found at server
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      //Serial.println(payload);
    } else {
      // HTTP header has been send and Server response header has been handled
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end();      
}

void loop() {
  // generate 10-us pulse to TRIG pin
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);
  digitalWrite(TRIG_PIN, LOW);

  // measure duration of pulse from ECHO pin
  duration = pulseIn(ECHO_PIN, HIGH);

  // calculate the distance
  distance = 0.03463 / 2 * duration;  //speed of sound at 30 celcious around is 346.3m/s
  if (distance <= 15) {

    digitalWrite(RED_LED, HIGH);  // turn RED RED_RED_LED ON
    digitalWrite(GREEN_LED, LOW);
    digitalWrite(BUZZER, LOW);  // turn OFF BUZZER as active low
    digitalWrite(MOTOR, HIGH);  // turn OFF MOTOR
    lcd.noBacklight();
    
  } 

if (distance >= 100) {

    digitalWrite(RED_LED, LOW);  // turn RED_LED OFF
    digitalWrite(GREEN_LED, HIGH);
    digitalWrite(BUZZER, HIGH);  // turn BUZZER OFF
    digitalWrite(MOTOR, LOW);  // turn MOTOR OFF 
    lcd.backlight();
  } 

lcd.clear();
lcd.setCursor(0, 0);  // start to print at the first row
lcd.print("Tank 1 Monitor ");
lcd.setCursor(0, 1);  // start to print at character 0, row 2
lcd.print("Level: ");
lcd.print(distance);
//lcd.print("cm");


HTTPClient http;

  String HOST_NAME1 = "http://192.168.137.251";  // change to your PC's IP address
  String PATH_NAME1 = "/Lab5/lab5/insert_waterlevel.php";
  String queryString1 = "?TankID=" + String(TANKID) + "&LocationID" + String(LOCATIONID) + "&OwnerID" + String(OWNERID) + "&WaterLevel" + String(distance);

  http.begin(HOST_NAME1 + PATH_NAME1 + queryString1);  //HTTP
  int httpCode = http.GET();

  // httpCode will be negative on error
  if (httpCode > 0) {
    // file found at server
    if (httpCode == HTTP_CODE_OK) {
      String payload = http.getString();
      Serial.println(payload);
    } else {
      // HTTP header has been send and Server response header has been handled
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end();
  delay(1000);
}