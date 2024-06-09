<template>
  <div>
    <VCard class="cal">
      <v-sheet class="d-flex" height="54" tile>
        <v-select
          v-model="type"
          :items="types"
          class="ma-2"
          label="View Mode"
          variant="outlined"
          dense
          hide-details
        ></v-select>
        <v-select
          v-model="weekday"
          :items="weekdays"
          class="ma-2"
          label="weekdays"
          variant="outlined"
          dense
          hide-details
        ></v-select>
      </v-sheet>
      <v-sheet>
        <v-calendar
          ref="calendar"
          v-model="value"
          :events="events"
          :view-mode="type"
          :weekdays="weekday"
        >
          <template v-slot:event-overlap="{ event }">
            <v-list-item>
              <v-list-item-content>
                <v-list-item-title>{{ event.title }}</v-list-item-title>
                <v-list-item-subtitle>{{ event.start }} - {{ event.end }}</v-list-item-subtitle>
                <!-- Add more information about the event here -->
              </v-list-item-content>
            </v-list-item>
          </template>
        </v-calendar>
      </v-sheet>
    </VCard>
  </div>
</template>

<script>
export default {
  data: () => ({
    type: 'month',
    types: ['month', 'week', 'day'],
    weekday: [0, 1, 2, 3, 4, 5, 6],
    weekdays: [
      { title: 'Sun - Sat', value: [0, 1, 2, 3, 4, 5, 6] },
      { title: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0] },
      { title: 'Mon - Fri', value: [1, 2, 3, 4, 5] },
      { title: 'Mon, Wed, Fri', value: [1, 3, 5] },
    ],
    value: [new Date()],
    events: [
      {
        title: 'Design workshop',
        start: new Date('2024-06-03'),
        end: new Date('2024-06-03'),
        color: 'red',
        allDay: true,
      },
      {
        title: 'First Session',
        start: new Date('2024-06-03'),
        end: new Date('2024-06-03'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Starts at : 9:00',
        start: new Date('2024-06-03'),
        end: new Date('2024-06-03'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Ends at 12:00',
        start: new Date('2024-06-03'),
        end: new Date('2024-06-03'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Trainer Amin',
        start: new Date('2024-06-03'),
        end: new Date('2024-06-03'),
        color: 'red',
        allDay: false,
      },


      {
        title: 'Backend workshop',
        start: new Date('2024-06-05'),
        end: new Date('2024-06-05'),
        color: 'red',
        allDay: true,
      },
      {
        title: 'First Session',
        start: new Date('2024-06-05'),
        end: new Date('2024-06-05'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Starts at : 14:00',
        start: new Date('2024-06-05'),
        end: new Date('2024-06-05'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Ends at 18:00',
        start: new Date('2024-06-05'),
        end: new Date('2024-06-05'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Trainer Lamia',
        start: new Date('2024-06-05'),
        end: new Date('2024-06-05'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Backend workshop',
        start: new Date('2024-06-06'),
        end: new Date('2024-06-06'),
        color: 'red',
        allDay: true,
      },
      {
        title: 'Second Session',
        start: new Date('2024-06-06'),
        end: new Date('2024-06-06'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Starts at : 8:00',
        start: new Date('2024-06-06'),
        end: new Date('2024-06-06'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Ends at 11:30',
        start: new Date('2024-06-06'),
        end: new Date('2024-06-06'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Trainer Lamia',
        start: new Date('2024-06-06'),
        end: new Date('2024-06-06'),
        color: 'red',
        allDay: false,
      },

      {
        title: 'Artificial Intelligence',
        start: new Date('2024-06-11'),
        end: new Date('2024-06-11'),
        color: 'red',
        allDay: true,
      },
      {
        title: 'Initiative Session',
        start: new Date('2024-06-11'),
        end: new Date('2024-06-11'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Starts at : 9:00',
        start: new Date('2024-06-11'),
        end: new Date('2024-06-11'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Ends at 14:00',
        start: new Date('2024-06-11'),
        end: new Date('2024-06-11'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Trainer Houssem',
        start: new Date('2024-06-11'),
        end: new Date('2024-06-11'),
        color: 'red',
        allDay: false,
      },

      {
        title: 'Network Fundamentals ',
        start: new Date('2024-06-14'),
        end: new Date('2024-06-14'),
        color: 'red',
        allDay: true,
      },
      {
        title: 'Initiative Session',
        start: new Date('2024-06-14'),
        end: new Date('2024-06-14'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Starts at : 10:00',
        start: new Date('2024-06-14'),
        end: new Date('2024-06-14'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Ends at 15:00',
        start: new Date('2024-06-14'),
        end: new Date('2024-06-14'),
        color: 'red',
        allDay: false,
      },
      {
        title: 'Trainer Mouna',
        start: new Date('2024-06-14'),
        end: new Date('2024-06-14'),
        color: 'red',
        allDay: false,
      },

    ],
  }),
};
</script>

<style lang="scss" scoped>
.cal {
  padding: 10px;
}
</style>
