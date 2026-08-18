<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:connection-request-modal */
class __TwigTemplate_3f2869f15e5767619d2f29f0aaa0fc30 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--connection-request-modal"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:connection-request-modal"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:connection-request-modal"));
        yield "<div x-show=\"open\" x-cloak class=\"fixed inset-0 z-[100] flex items-center justify-center p-6\">
  <div class=\"absolute inset-0 bg-black/50\" x-on:click=\"open = false\"></div>

  <div class=\"relative bg-white rounded-2xl shadow-2xl max-w-[560px] w-full max-h-[90vh] overflow-y-auto\" x-data=\"{ type: \x27cfca\x27, submitted: false }\">
    <div class=\"flex items-center justify-between px-8 pt-8 pb-6 border-b border-neutral-100\">
      <h2 class=\"text-neutral-900 tracking-tight\" style=\"font-size: 22px; font-weight: 600;\">Submit a Connection Request</h2>
      <button type=\"button\" x-on:click=\"open = false\" class=\"text-neutral-400 hover:text-neutral-700\">
        ";
        // line 8
        yield from $this->load("cfc_media_hub:icon", 8)->unwrap()->yield(CoreExtension::toArray(["name" => "x", "size" => "w-5 h-5"]));
        // line 9
        yield "      </button>
    </div>

    <div x-show=\"submitted\" x-cloak class=\"px-8 py-12 text-center\">
      <div class=\"w-12 h-12 rounded-full bg-[#E1F5EE] text-[#0F6E56] flex items-center justify-center mx-auto mb-4\">
        ";
        // line 14
        yield from $this->load("cfc_media_hub:icon", 14)->unwrap()->yield(CoreExtension::toArray(["name" => "check", "size" => "w-6 h-6"]));
        // line 15
        yield "      </div>
      <div class=\"text-neutral-900 font-semibold text-[16px] mb-2\">Request submitted.</div>
      <p class=\"text-neutral-500 text-[14px]\">Our team will get back to you shortly to coordinate the introduction.</p>
      <button type=\"button\" x-on:click=\"open = false\" class=\"mt-6 text-[13px] font-semibold text-[#0F6E56] hover:text-[#085041]\">Close</button>
    </div>

    <form x-show=\"!submitted\" x-on:submit.prevent=\"submitted = true\" class=\"px-8 py-6 space-y-5\">
      <div>
        <label class=\"block text-[13px] font-medium text-neutral-700 mb-2\">I want to connect with</label>
        <div class=\"space-y-2\">
          <label class=\"flex items-center gap-2 text-[14px] text-neutral-700\">
            <input type=\"radio\" name=\"connection_type\" value=\"cfca\" x-model=\"type\" class=\"accent-[#0F6E56]\" />
            CFCA
          </label>
          <label class=\"flex items-center gap-2 text-[14px] text-neutral-700\">
            <input type=\"radio\" name=\"connection_type\" value=\"member\" x-model=\"type\" class=\"accent-[#0F6E56]\" />
            A CFC Member company
          </label>
          <label class=\"flex items-center gap-2 text-[14px] text-neutral-700\">
            <input type=\"radio\" name=\"connection_type\" value=\"other\" x-model=\"type\" class=\"accent-[#0F6E56]\" />
            Another organisation
          </label>
        </div>
      </div>

      <div x-show=\"type !== \x27cfca\x27\" x-cloak>
        <label for=\"connection-org\" class=\"block text-[13px] font-medium text-neutral-700 mb-1.5\">Organisation name</label>
        <input id=\"connection-org\" type=\"text\" name=\"organisation\" class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] focus:outline-none focus:border-[#0F6E56]/50\" />
      </div>

      <div>
        <label for=\"connection-purpose\" class=\"block text-[13px] font-medium text-neutral-700 mb-1.5\">Purpose of request</label>
        <textarea id=\"connection-purpose\" name=\"purpose\" required rows=\"3\" class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] focus:outline-none focus:border-[#0F6E56]/50\"></textarea>
      </div>

      <div class=\"grid grid-cols-2 gap-4\">
        <div>
          <label for=\"connection-name\" class=\"block text-[13px] font-medium text-neutral-700 mb-1.5\">Your name</label>
          <input id=\"connection-name\" type=\"text\" name=\"name\" required class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] focus:outline-none focus:border-[#0F6E56]/50\" />
        </div>
        <div>
          <label for=\"connection-email\" class=\"block text-[13px] font-medium text-neutral-700 mb-1.5\">Email address</label>
          <input id=\"connection-email\" type=\"email\" name=\"email\" required class=\"w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] focus:outline-none focus:border-[#0F6E56]/50\" />
        </div>
      </div>

      <button type=\"submit\" class=\"w-full bg-[#9F5434] hover:bg-[#8A4A2E] text-white py-3.5 rounded-xl text-[14px] font-semibold transition-colors\">
        Submit request
      </button>
    </form>
  </div>
</div>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:connection-request-modal";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  67 => 15,  65 => 14,  58 => 9,  56 => 8,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:connection-request-modal", "themes/custom/cfc_media_hub/components/connection-request-modal/connection-request-modal.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 8];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "include"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
