/*

 Program for water level monitoring with LCD and Ultrasonic sensor
 */
//LIBRARY CONFIGURATION
#include <LiquidCrystal_I2C.h>
#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFi.h>
#include <WiFiClient.h>
#include <WebServer.h>
#include <ESPmDNS.h>

//PIN DECLARATION
#define TRIG_PIN 5   // ESP32 pin GIOP5 connected to Ultrasonic Sensor's TRIG pin
#define ECHO_PIN 18  // ESP32 pin GIOP18 connected to Ultrasonic Sensor's ECHO pin
#define RED_LED 33
#define GREEN_LED 19
#define BUZZER 32
#define MOTOR 23
#define Threshold 40
touch_pad_t touchPin;

//sleeping
#define uS_TO_S_FACTOR 1000000ULL  /* Conversion factor for micro seconds to seconds */
#define TIME_TO_SLEEP  5        /* Time ESP32 will go to sleep (in seconds) */

RTC_DATA_ATTR int bootCount = 0;


const int led = 2;

float duration, distance;
const int TANKID = 1;
const int LOCATIONID = 1;
const int OWNERID = 1;

const char WIFI_SSID[] = "SIMBARASHE";
const char WIFI_PASSWORD[] = "01234567";

String HOST_NAME = "http://192.168.137.34";  // change to your PC's IP address
String PATH_NAME = "/Lab5/lab5/insert_waterlevel.php";
String queryString = "?TankID=1&LocationID=1&OwnerID=1&WaterLevel=2";

LiquidCrystal_I2C lcd(0x27, 16, 2);  // I2C address 0x27, 16 column and 2 rows
WebServer server(80);


void systm() {
  delay(100);  //record data every second
  //RUN SERVER
  server.handleClient();
  delay(2);  //allow the cpu to switch to other tasks

  //CONFIGURE ULTRASONIC
  digitalWrite(TRIG_PIN, HIGH);
  delayMicroseconds(10);  // generate 10-us pulse to TRIG pin
  digitalWrite(TRIG_PIN, LOW);
  duration = pulseIn(ECHO_PIN, HIGH);  // measure duration of pulse from ECHO pin
  // calculate the distance
  distance = 0.03463 / 2 * duration;  //speed of sound at 30 celcious around is 346.3m/s

  //CONFIGURE SYSTEM DISPLAY
  lcd.clear();
  lcd.setCursor(0, 0);  // start to print at the first row
  lcd.print("Tank 1 Monitor ");
  lcd.setCursor(0, 1);  // start to print at character 0, row 2
  lcd.print("Level: ");
  lcd.print(distance);
  //lcd.print("cm");

  //CONFIGURE DATABASE STORAGE
  HTTPClient http;
  String HOST_NAME1 = "http://192.168.137.34";  // change to your PC's IP address
  String PATH_NAME1 = "/Lab5/lab5/insert_waterlevel.php";
  String queryString1 = "?TankID=" + String(TANKID) + "&LocationID=" + String(LOCATIONID) + "&OwnerID=" + String(OWNERID) + "&WaterLevel=" + String(distance);

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
}



void handleRoot() {
  while (1) {
    systm();
    //CONFIGURE DEFAULT AUTOMATIC SYSTEM
    if (distance <= 15) {            //minimum water level 15cm
      digitalWrite(RED_LED, HIGH);   // turn RED RED_RED_LED ON
      digitalWrite(GREEN_LED, LOW);  //normal operation
      digitalWrite(BUZZER, LOW);     // turn OFF BUZZER as active low
      digitalWrite(MOTOR, HIGH);     // turn OFF MOTOR
      //digitalWrite(led, HIGH);    // turn OFF MOTOR
      digitalWrite(led, 1);
    }

    if (distance >= 100) {
      digitalWrite(RED_LED, LOW);  // turn RED_LED OFF
      digitalWrite(GREEN_LED, HIGH);
      digitalWrite(BUZZER, HIGH);  // turn BUZZER OFF
      digitalWrite(MOTOR, LOW);    // turn MOTOR OFF
      digitalWrite(led, 0);        // turn OFF MOTOR
    }
    server.send(200, "text/plain", "SYSTEM ON AUTO");
  }
}

void handleRoot2() {
  while (1) {
    systm();
    digitalWrite(MOTOR, HIGH);  // turn OFF MOTOR
    digitalWrite(led, HIGH);    // turn OFF MOTOR
    server.send(200, "text/plain", "MOTOR IS ON");
    if (distance <= 15) {            //minimum water level 15cm
      digitalWrite(RED_LED, HIGH);   // turn RED RED_RED_LED ON
      digitalWrite(GREEN_LED, LOW);  //normal operation
      digitalWrite(BUZZER, LOW);     // turn OFF BUZZER as active low
    }

    if (distance >= 100) {
      digitalWrite(RED_LED, LOW);  // turn RED_LED OFF
      digitalWrite(GREEN_LED, HIGH);
      digitalWrite(BUZZER, HIGH);  // turn BUZZER OFF
    }
  }
}
void handleRoot3() {
  while (1) {
    systm();
    digitalWrite(MOTOR, LOW);        // turn OFF MOTOR
    digitalWrite(led, 0);            // turn OFF MOTOR
    if (distance <= 15) {            //minimum water level 15cm
      digitalWrite(RED_LED, HIGH);   // turn RED RED_RED_LED ON
      digitalWrite(GREEN_LED, LOW);  //normal operation
      digitalWrite(BUZZER, LOW);     // turn OFF BUZZER as active low
    }

    if (distance >= 100) {
      digitalWrite(RED_LED, LOW);  // turn RED_LED OFF
      digitalWrite(GREEN_LED, HIGH);
      digitalWrite(BUZZER, HIGH);  // turn BUZZER OFF
    }
    server.send(200, "text/plain", "MOTOR IS ON");
  }
}

void print_wakeup_reason(){
  esp_sleep_wakeup_cause_t wakeup_reason;

  wakeup_reason = esp_sleep_get_wakeup_cause();

  switch(wakeup_reason)
  {
    
    case ESP_SLEEP_WAKEUP_TIMER : Serial.println("Wakeup caused by timer"); break;
    case ESP_SLEEP_WAKEUP_TOUCHPAD : Serial.println("Wakeup caused by touchpad"); break;
    default : Serial.printf("Wakeup was not caused by deep sleep: %d\n",wakeup_reason); break;
  }
}

void callback(){
  //placeholder callback function
}

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

  // CONFIGURING WEBSERVER
  pinMode(led, OUTPUT);
  digitalWrite(led, 0);
  digitalWrite(BUZZER, HIGH);
  
  WiFi.mode(WIFI_STA);

  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.println("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.print("Connected to ");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());

  if (MDNS.begin("esp32")) {
    Serial.println("MDNS responder started");
  }

  server.on("/AUTO", handleRoot);
  server.on("/ON", handleRoot2);
  server.on("/OFF", handleRoot3);
  server.begin();
  Serial.println("HTTP server started");

  //configuring HTTP
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
  print_wakeup_reason();
  systm();
  //CONFIGURE DEFAULT AUTOMATIC SYSTEM
  if (distance <= 15) {            //minimum water level 15cm
    digitalWrite(RED_LED, HIGH);   // turn RED RED_RED_LED ON
    digitalWrite(GREEN_LED, LOW);  //normal operation
    digitalWrite(BUZZER, LOW);     // turn OFF BUZZER as active low
    digitalWrite(MOTOR, HIGH);     // turn ON MOTOR
    digitalWrite(led, HIGH);       // turn ON MOTOR LED
  }

  if (distance >= 100) {
    digitalWrite(RED_LED, LOW);  // turn RED_LED OFF
    digitalWrite(GREEN_LED, HIGH);
    digitalWrite(BUZZER, HIGH);  // turn BUZZER OFF
    digitalWrite(MOTOR, LOW);    // turn MOTOR OFF
    digitalWrite(led, LOW);      // turn MOTOR LED OFF

    ++bootCount;
  Serial.println("Boot number: " + String(bootCount));

  //Print the wakeup reason for ESP32
  touchAttachInterrupt(T3, callback, Threshold);
  
  esp_sleep_enable_touchpad_wakeup();
  esp_sleep_enable_timer_wakeup(45 * uS_TO_S_FACTOR);
  
  
  Serial.println("Setup ESP32 to sleep for every " + String(TIME_TO_SLEEP) +
  " Seconds");

  Serial.println("Going to sleep now");
    delay(2000);
  Serial.flush(); 
  lcd.noBacklight();
 
  esp_deep_sleep_start();   
  }
}

