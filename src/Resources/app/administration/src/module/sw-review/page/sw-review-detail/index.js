import template from './sw-review-detail.html.twig';

const { Component } = Shopware;

Component.override('sw-review-detail', {
  template,

  data() {
    return {
      isAiGenerating: false
    };
  },

  methods: {
    async onDraftWithAi() {
      this.isAiGenerating = true;

      try {
        // Call the PHP API route we created in Part 2 via httpClient service
        const response = await Shopware.Application.getContainer('init').httpClient.post('/_action/ai-review/generate', {
          reviewText: this.review.content,
          rating: this.review.points
        });

        // Update the Vue state with the generated text
        this.review.comment = response.data.draft;

        // Show a success notification
        this.createNotificationSuccess({
          message: 'AI Draft generated successfully!'
        });
      } catch (error) {
        this.createNotificationError({
          message: 'Failed to generate AI response.'
        });
        console.error('AI Generation Error:', error);
      } finally {
        this.isAiGenerating = false;
      }
    }
  }
});
