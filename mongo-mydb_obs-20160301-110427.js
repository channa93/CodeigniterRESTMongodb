
/** notebook records **/
db.getCollection("notebook").insert({
  "_id": ObjectId("56cbb41af8d573f05583e461"),
  "name": "MongoDB",
  "notes": [
    {
      "title": "Hello MongoDB",
      "content": "Hello MongoDB introduction"
    },
    {
      "title": "ReplicaSet MongoDB",
      "content": "ReplicaSet MongoDB"
    }
  ]
});
